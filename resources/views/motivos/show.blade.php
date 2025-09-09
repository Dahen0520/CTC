<x-app-layout>
    <x-slot name="header">
        Detalles del Motivo
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Breadcrumb y navegación --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('motivos.index') }}" class="text-chorotega-blue hover:text-chorotega-blue-light transition duration-200 flex items-center">
                    <i class="fas fa-clipboard-list mr-1"></i>
                    Motivos
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-600 flex items-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Detalles
                </span>
            </nav>
        </div>

        {{-- Tarjeta de detalles del motivo --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            {{-- Header de la tarjeta --}}
            <div class="bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold text-white">Detalles del Motivo</h2>
                        <p class="text-blue-100 text-sm mt-1">Información completa de {{ $motivo->nombre }}</p>
                    </div>
                </div>
            </div>

            {{-- Contenido de la tarjeta --}}
            <div class="p-6">
                <div class="space-y-4">
                    {{-- Campo ID --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">ID</p>
                        <p class="mt-1 text-gray-900 text-base font-semibold">{{ $motivo->id }}</p>
                    </div>
                    
                    {{-- Campo de nombre --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Nombre del Motivo</p>
                        <p class="mt-1 text-gray-900 text-base">{{ $motivo->nombre }}</p>
                    </div>

                    {{-- Campo de fecha de creación --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Creado en</p>
                        <p class="mt-1 text-gray-900 text-base">{{ $motivo->created_at->format('d/m/Y H:i A') }}</p>
                    </div>

                    {{-- Campo de fecha de última actualización --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Última Actualización</p>
                        <p class="mt-1 text-gray-900 text-base">{{ $motivo->updated_at->format('d/m/Y H:i A') }}</p>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 mt-6">
                    <a href="{{ route('motivos.edit', $motivo) }}" 
                       class="flex-1 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-indigo-600 hover:to-indigo-500 transform hover:scale-105 transition duration-200 shadow-lg flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </a>
                    
                    <a href="{{ route('motivos.index') }}" 
                       class="flex-1 sm:flex-initial bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>