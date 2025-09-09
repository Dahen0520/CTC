<x-app-layout>
    <x-slot name="header">
        Detalles del Tipo de Visita
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Breadcrumb y navegación --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('tipo-visitas.index') }}" class="text-chorotega-blue hover:text-chorotega-blue-light transition duration-200 flex items-center">
                    <i class="fas fa-eye mr-1"></i>
                    Tipos de Visita
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-600 flex items-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Detalles
                </span>
            </nav>
        </div>

        {{-- Tarjeta de detalles del tipo de visita --}}
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
                        <h2 class="text-xl font-bold text-white">Detalles del Tipo de Visita</h2>
                        <p class="text-blue-100 text-sm mt-1">Información completa del tipo de visita {{ $tipoVisita->nombre }}</p>
                    </div>
                </div>
            </div>

            {{-- Contenido de la tarjeta --}}
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Campo ID --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">ID</p>
                        <p class="mt-1 text-gray-900 text-base font-semibold">{{ $tipoVisita->id }}</p>
                    </div>

                    {{-- Campo de estado --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Estado</p>
                        <div class="mt-1">
                             @if($tipoVisita->estado == 'activo')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-2.5 h-2.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                     <svg class="w-2.5 h-2.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Inactivo
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Campo de nombre --}}
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Nombre del Tipo de Visita</p>
                        <p class="mt-1 text-gray-900 text-base">{{ $tipoVisita->nombre }}</p>
                    </div>
                    
                    {{-- Campo de precio --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Precio</p>
                        <p class="mt-1 text-gray-900 text-base">L. {{ number_format($tipoVisita->precio, 2) }}</p>
                    </div>

                    {{-- Campo de fecha de creación --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Creado en</p>
                        <p class="mt-1 text-gray-900 text-base">{{ $tipoVisita->created_at->format('d/m/Y H:i A') }}</p>
                    </div>

                    {{-- Campo de fecha de última actualización --}}
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Última Actualización</p>
                        <p class="mt-1 text-gray-900 text-base">{{ $tipoVisita->updated_at->format('d/m/Y H:i A') }}</p>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 mt-6">
                    <a href="{{ route('tipo-visitas.edit', $tipoVisita) }}" 
                       class="flex-1 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-indigo-600 hover:to-indigo-500 transform hover:scale-105 transition duration-200 shadow-lg flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </a>
                    
                    <a href="{{ route('tipo-visitas.index') }}" 
                       class="flex-1 sm:flex-initial bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
