<x-app-layout>
    <x-slot name="header">
        Tipos de Visita
    </x-slot>

    {{-- Contenedor principal con el ID y el data-url para el script --}}
    <div id="tipo-visitas-container" data-url="{{ route('tipo-visitas.index') }}">
        <div class="space-y-6">
            {{-- Header Card con acciones principales --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-eye text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h1 class="text-xl lg:text-2xl font-bold text-white">Gestión de Tipos de Visita</h1>
                                <p class="text-sm text-blue-100 mt-1">Administra los tipos de visita del sistema</p>
                            </div>
                        </div>
                         
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="relative">
                                <input type="text" 
                                       id="search-input" 
                                       placeholder="Buscar tipos de visita..."
                                       class="w-full sm:w-64 pl-10 pr-4 py-2 border border-white border-opacity-30 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-100 focus:ring-2 focus:ring-white focus:border-transparent transition duration-200">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-blue-100"></i>
                                </div>
                            </div>
                             
                            <a href="{{ route('tipo-visitas.create') }}" 
                               class="inline-flex items-center justify-center px-4 py-2 bg-chorotega-yellow text-chorotega-blue font-semibold rounded-lg hover:bg-yellow-400 transform hover:scale-105 transition duration-200 shadow-lg">
                                <i class="fas fa-plus mr-2"></i>
                                Nuevo Tipo de Visita
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mensaje de éxito (SECCIÓN RESTAURADA) --}}
            @if (session('success'))
            <div id="success-alert" class="bg-white rounded-lg shadow-sm border border-green-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-white font-medium">¡Operación exitosa!</p>
                            <p class="text-green-100 text-sm">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.parentElement.style.display='none'" 
                                class="ml-auto flex-shrink-0 text-green-100 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            {{-- Tabla de tipos de visita --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        {{-- Títulos de las columnas (SECCIÓN RESTAURADA) --}}
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-tag text-gray-400"></i>
                                        <span>Nombre del Tipo de Visita</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-dollar-sign text-gray-400"></i>
                                        <span>Precio</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-toggle-on text-gray-400"></i>
                                        <span>Estado</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-cogs text-gray-400"></i>
                                        <span>Acciones</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tipo-visitas-table-body" class="bg-white divide-y divide-gray-200">
                            @include('tipo_visitas.partials.tipo_visitas_table_rows')
                        </tbody>
                    </table>
                </div>

                {{-- Empty state --}}
                <div id="empty-state" class="hidden text-center py-12">
                    <div class="max-w-md mx-auto">
                        <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-search text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron tipos de visita</h3>
                        <p class="text-gray-500 mb-6">Intenta con otros términos de búsqueda o crea un nuevo tipo de visita.</p>
                        <a href="{{ route('tipo-visitas.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-chorotega-blue text-white rounded-lg hover:bg-chorotega-blue-light transition duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Crear Primer Tipo de Visita
                        </a>
                    </div>
                </div>
            </div>

            {{-- Paginación --}}
            <div id="pagination-links" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                {{ $tipoVisitas->links() }}
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/tipo_visitas/index.js') }}"></script>
    
</x-app-layout>