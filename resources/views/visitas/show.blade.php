<x-app-layout>
    <x-slot name="header">
        Detalles de Visita
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('visitas.index') }}" class="text-chorotega-blue hover:text-chorotega-blue-light transition duration-200 flex items-center">
                    <i class="fas fa-eye mr-1"></i>
                    Visitas
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-600 flex items-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Detalles
                </span>
            </nav>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold text-white">Detalles de la Visita</h2>
                        <p class="text-blue-100 text-sm mt-1">Información completa del registro</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">ID</p>
                        <p class="mt-1 text-gray-900 text-base font-semibold">{{ $visita->id }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Tipo de Visita</p>
                        <p class="mt-1 text-gray-900 text-base">{{ $visita->tipoVisita->nombre }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Fecha</p>
                        <p class="mt-1 text-gray-900 text-base">{{ \Carbon\Carbon::parse($visita->fecha)->format('d/m/Y') }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Número de Identidad</p>
                        <p class="mt-1 text-gray-900 text-base">{{ $visita->numero_identidad ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Creado en</p>
                        <p class="mt-1 text-gray-900 text-base">{{ $visita->created_at->format('d/m/Y H:i A') }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Última Actualización</p>
                        <p class="mt-1 text-gray-900 text-base">{{ $visita->updated_at->format('d/m/Y H:i A') }}</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 mt-6">
                    <!--<a href="{{ route('visitas.edit', $visita) }}" 
                       class="flex-1 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-indigo-600 hover:to-indigo-500 transform hover:scale-105 transition duration-200 shadow-lg flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </a>-->
                    
                    <a href="{{ route('visitas.index') }}" 
                       class="flex-1 sm:flex-initial bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>