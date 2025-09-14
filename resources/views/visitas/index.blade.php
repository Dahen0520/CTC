<x-app-layout>
    <x-slot name="header"></x-slot>

    <div id="visitas-container" data-url="{{ route('visitas.index') }}">
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-eye text-white text-3xl"></i>
                            </div>
                            <div class="ml-4">
                                <h1 class="text-2xl font-bold text-white">Gestión de Visitas</h1>
                                <p class="text-sm text-blue-100 mt-1">Administra los registros de visita del sistema</p>
                            </div>
                        </div>
                        @can('create', App\Models\Visita::class)
                        <a href="{{ route('visitas.registrar') }}" 
                           class="w-full md:w-auto inline-flex items-center justify-center px-5 py-3 bg-chorotega-yellow text-chorotega-blue font-semibold rounded-lg hover:bg-yellow-400 transform hover:scale-105 transition duration-200 shadow-lg whitespace-nowrap">
                            <i class="fas fa-plus mr-2"></i>
                            Nueva Visita
                        </a>
                        @endcan
                    </div>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <div class="relative">
                            <label for="search-input" class="block text-xs font-medium text-blue-100 mb-1">Búsqueda General</label>
                            <input type="text" 
                                   id="search-input" 
                                   placeholder="Buscar por DNI o tipo..."
                                   class="w-full pl-10 pr-4 py-2 border border-white border-opacity-30 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-100 focus:ring-2 focus:ring-white focus:border-transparent transition duration-200">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none top-6">
                                <i class="fas fa-search text-blue-100"></i>
                            </div>
                        </div>

                        <div>
                            <label for="filter-tipo-visita" class="block text-xs font-medium text-blue-100 mb-1">Tipo de Visita</label>
                            <select id="filter-tipo-visita" name="tipo_visita_id" class="w-full pl-4 pr-10 py-2 border border-white border-opacity-30 rounded-lg bg-white bg-opacity-20 text-white focus:ring-2 focus:ring-white focus:border-transparent transition duration-200">
                                <option value="" class="text-black">Todos los tipos</option>
                                @foreach($tiposVisita as $tipo)
                                    <option value="{{ $tipo->id }}" {{ request('tipo_visita_id') == $tipo->id ? 'selected' : '' }} class="text-black">
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="w-full">
                                <label for="filter-fecha-inicio" class="block text-xs font-medium text-blue-100 mb-1">Desde</label>
                                <input type="date" id="filter-fecha-inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}" style="color-scheme: dark;" class="w-full px-4 py-2 border border-white border-opacity-30 rounded-lg bg-white bg-opacity-20 text-white focus:ring-2 focus:ring-white focus:border-transparent transition duration-200">
                            </div>
                            <div class="w-full">
                                 <label for="filter-fecha-fin" class="block text-xs font-medium text-blue-100 mb-1">Hasta</label>
                                <input type="date" id="filter-fecha-fin" name="fecha_fin" value="{{ request('fecha_fin') }}" style="color-scheme: dark;" class="w-full px-4 py-2 border border-white border-opacity-30 rounded-lg bg-white bg-opacity-20 text-white focus:ring-2 focus:ring-white focus:border-transparent transition duration-200">
                            </div>
                        </div>
                        
                        <div>
                             <a href="{{ route('visitas.index') }}" title="Limpiar filtros" class="w-full inline-flex items-center justify-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition duration-200">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Limpiar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

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

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-hashtag text-gray-400"></i>
                                        <span>No.</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-tag text-gray-400"></i>
                                        <span>TIPO DE VISITA</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-dollar-sign text-gray-400"></i>
                                        <span>PRECIO</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                        <span>FECHA</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                        <span>NÚMERO DE IDENTIDAD</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center justify-center space-x-1">
                                        <i class="fas fa-cogs text-gray-400"></i>
                                        <span>ACCIONES</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="visitas-table-body" class="bg-white divide-y divide-gray-200">
                            @include('visitas.partials.visitas_table_rows')
                        </tbody>
                    </table>
                </div>

                <div id="empty-state" class="hidden text-center py-12">
                    <div class="max-w-md mx-auto">
                        <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-search text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron visitas</h3>
                        <p class="text-gray-500 mb-6">Prueba con otros filtros o registra una nueva visita.</p>
                        @can('create', App\Models\Visita::class)
                        <a href="{{ route('visitas.registrar') }}" 
                           class="inline-flex items-center px-4 py-2 bg-chorotega-blue text-white rounded-lg hover:bg-chorotega-blue-light transition duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Registrar Primera Visita
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div id="pagination-links" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                {!! $visitas->links() !!}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/visitas/index.js') }}"></script>
</x-app-layout>