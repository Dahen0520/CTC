<x-app-layout>
    <x-slot name="header">
        
    </x-slot>

    <div id="visita-form-container"
         class="max-w-6xl mx-auto space-y-8 p-4 sm:p-6"
         data-tipos-visita='{{ json_encode($tiposVisita->keyBy('id')) }}'
         data-verificar-url="{{ route('afiliados.verificar') }}">

        @can('create', App\Models\Visita::class)
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-br from-chorotega-blue via-blue-600 to-chorotega-blue-light p-6 sm:p-8 relative overflow-hidden">
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                <div class="absolute top-0 right-0 transform translate-x-16 -translate-y-8">
                    <div class="w-32 h-32 bg-white bg-opacity-10 rounded-full"></div>
                </div>
                <div class="absolute bottom-0 left-0 transform -translate-x-8 translate-y-8">
                    <div class="w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
                </div>
                
                <div class="relative flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white border-opacity-30">
                            <i class="fas fa-clipboard-list text-white text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 sm:ml-6">
                        <h2 class="text-xl sm:text-2xl font-bold text-white mb-1">Registrar Nueva Visita</h2>
                        <p class="text-blue-100 text-sm sm:text-base">Selecciona los tipos de visita y cantidades necesarias</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-sm">
                    <h3 class="text-sm font-medium text-red-800 mb-2">Se encontraron errores:</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="visita-form" method="POST" action="{{ route('visitas.store') }}" class="space-y-6 sm:space-y-8">
                    @csrf
                    
                    <div class="flex items-center mb-4 sm:mb-6">
                        <div class="flex-grow h-px bg-gray-200"></div>
                        <h3 class="px-4 sm:px-6 text-base sm:text-lg font-semibold text-gray-700 bg-white">Tipos de Visita Disponibles</h3>
                        <div class="flex-grow h-px bg-gray-200"></div>
                    </div>
                    
                    <div id="visita-counters-list" class="space-y-4 sm:space-y-6">
                        @foreach($tiposVisita as $tipo)
                        <div id="tipo-visita-{{ $tipo->id }}" class="group bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-4 sm:p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-blue-300">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex items-center flex-1">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-chorotega-blue to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow mr-4 sm:mr-6">
                                        <i class="fas fa-ticket-alt text-white text-lg sm:text-xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-1 truncate">{{ $tipo->nombre }}</h4>
                                        <div class="flex flex-col sm:flex-row sm:items-center">
                                            <span class="text-2xl sm:text-3xl font-bold text-chorotega-blue">L. {{ number_format($tipo->precio, 2) }}</span>
                                            <span class="text-sm text-gray-500 sm:ml-2">por visita</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-center space-x-4 bg-white rounded-xl p-4 shadow-sm flex-shrink-0">
                                    <button type="button" class="decrement-btn w-12 h-12 sm:w-14 sm:h-14 bg-red-100 hover:bg-red-200 text-red-600 hover:text-red-700 rounded-xl transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md transform hover:scale-105 active:scale-95" data-id="{{ $tipo->id }}">
                                        <i class="fas fa-minus text-lg font-bold"></i>
                                    </button>
                                    
                                    <div class="text-center min-w-[80px] sm:min-w-[100px]">
                                        <span class="counter-display text-3xl sm:text-4xl font-bold text-gray-800 block leading-none" data-id="{{ $tipo->id }}">0</span>
                                        <span class="text-sm text-gray-500 mt-1 block">cantidad</span>
                                    </div>
                                    
                                    <button type="button" class="increment-btn w-12 h-12 sm:w-14 sm:h-14 bg-green-100 hover:bg-green-200 text-green-600 hover:text-green-700 rounded-xl transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md transform hover:scale-105 active:scale-95" data-id="{{ $tipo->id }}">
                                        <i class="fas fa-plus text-lg font-bold"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <input type="hidden" name="visitas[{{ $tipo->id }}]" value="0" class="visita-input-field">

                            @if ($tipo->nombre === 'Afiliado')
                            <div id="afiliado-dni-container" class="mt-4 sm:mt-6 space-y-3 sm:space-y-4"></div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div id="precio-info" class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6 sm:p-8 hidden shadow-lg">
                       <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-blue-500 rounded-2xl flex items-center justify-center shadow-md flex-shrink-0">
                                    <i class="fas fa-calculator text-white text-lg sm:text-xl"></i>
                                </div>
                                <div class="ml-4 sm:ml-6">
                                    <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-1">Resumen de Pago</h4>
                                    <p class="text-gray-600 text-sm sm:text-base">Total a pagar por todas las visitas</p>
                                </div>
                            </div>
                            <div class="text-center sm:text-right">
                                <p class="text-sm text-gray-600 mb-1">Total</p>
                                <p class="text-3xl sm:text-4xl font-bold text-blue-600">
                                    L. <span id="precio-display">0.00</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-6 sm:pt-8 border-t border-gray-200">
                        <button type="submit" id="submit-btn" disabled class="flex-1 bg-gray-400 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold cursor-not-allowed flex items-center justify-center text-base sm:text-lg transition-all duration-300 shadow-lg order-2 sm:order-1">
                            <i class="fas fa-save mr-2 sm:mr-3"></i>
                            <span class="hidden xs:inline">Guardar Visita</span>
                            <span class="xs:hidden">Guardar</span>
                        </button>
                        
                        <a href="{{ route('visitas.index') }}" class="flex-1 sm:flex-initial bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold transition-all duration-300 flex items-center justify-center text-base sm:text-lg shadow-lg hover:shadow-xl order-1 sm:order-2">
                            <i class="fas fa-times mr-2 sm:mr-3"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-xl border border-red-200 overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lock text-red-500 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold text-red-800">Acceso Denegado</h2>
                        <p class="text-gray-600 text-sm sm:text-base mt-1">No tienes los permisos necesarios para registrar nuevas visitas.</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/visitas/registrar.js') }}"></script>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
        @media (min-width: 480px) {
            .xs\:inline { display: inline; }
            .xs\:hidden { display: none; }
        }
        @media (max-width: 479px) {
            .xs\:inline { display: none; }
            .xs\:hidden { display: inline; }
        }
    </style>
</x-app-layout>