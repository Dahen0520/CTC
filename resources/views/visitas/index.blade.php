<x-app-layout>
    <x-slot name="header"></x-slot>
    <div class="space-y-6">
        {{-- Header Card con acciones y filtros integrados --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light p-6">
                {{-- Fila superior: Título y botón de Nueva Visita --}}
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
                    <a href="{{ route('visitas.registrar') }}" 
                       class="w-full md:w-auto inline-flex items-center justify-center px-5 py-3 bg-chorotega-yellow text-chorotega-blue font-semibold rounded-lg hover:bg-yellow-400 transform hover:scale-105 transition duration-200 shadow-lg whitespace-nowrap">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Visita
                    </a>
                </div>

                {{-- Fila inferior: Filtros y búsqueda --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    
                    {{-- Búsqueda General --}}
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

                    {{-- Filtro Tipo de Visita --}}
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

                    {{-- Filtro de Fechas --}}
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
                    
                    {{-- Botón Limpiar --}}
                    <div>
                         <a href="{{ route('visitas.index') }}" title="Limpiar filtros" class="w-full inline-flex items-center justify-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition duration-200">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Limpiar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mensaje de éxito --}}
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

        {{-- Tabla de visitas --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            {{-- ID --}}
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                    <span>ID</span>
                                </div>
                            </th>
                            {{-- Tipo de Visita --}}
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-tag text-gray-400"></i>
                                    <span>TIPO DE VISITA</span>
                                </div>
                            </th>
                             {{-- Precio --}}
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-dollar-sign text-gray-400"></i>
                                    <span>PRECIO</span>
                                </div>
                            </th>
                            {{-- Fecha --}}
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                    <span>FECHA</span>
                                </div>
                            </th>
                            {{-- Número de Identidad --}}
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-id-card text-gray-400"></i>
                                    <span>NÚMERO DE IDENTIDAD</span>
                                </div>
                            </th>
                            {{-- Acciones (Alineado al centro) --}}
                            <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center justify-center space-x-1"> {{-- Añadido justify-center aquí --}}
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

            {{-- Empty state --}}
            <div id="empty-state" class="hidden text-center py-12">
                <div class="max-w-md mx-auto">
                    <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-search text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron visitas</h3>
                    <p class="text-gray-500 mb-6">Prueba con otros filtros o registra una nueva visita.</p>
                    <a href="{{ route('visitas.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-chorotega-blue text-white rounded-lg hover:bg-chorotega-blue-light transition duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Registrar Primera Visita
                    </a>
                </div>
            </div>
        </div>

        {{-- Paginación --}}
        <div id="pagination-links" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            {{ $visitas->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-hide success alert
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => successAlert.style.display = 'none', 5000);
            }

            const searchInput = document.getElementById('search-input');
            const visitasTableBody = document.getElementById('visitas-table-body');
            const paginationLinksContainer = document.getElementById('pagination-links');
            const emptyState = document.getElementById('empty-state');
            let searchTimeout;

            // Selectores para los filtros
            const filterFechaInicio = document.getElementById('filter-fecha-inicio');
            const filterFechaFin = document.getElementById('filter-fecha-fin');
            const filterTipoVisita = document.getElementById('filter-tipo-visita');

            function handleDeleteClick(e) {
                e.preventDefault();
                const form = this.closest('form');
                const visitaId = this.getAttribute('data-id');

                Swal.fire({
                    title: '¿Eliminar visita?',
                    text: `¿Estás seguro de que deseas eliminar este registro de visita?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        popup: 'rounded-xl',
                        confirmButton: 'rounded-lg',
                        cancelButton: 'rounded-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData(form);
                        
                        fetch(form.action, {
                            method: 'POST', // Asegúrate de que este método coincida con la ruta DELETE
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: '¡Eliminado!',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'rounded-xl'
                                    }
                                });
                                fetchVisitas(getCurrentPage());
                            } else {
                                throw new Error(data.message || 'Error al eliminar');
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Error',
                                text: error.message,
                                icon: 'error',
                                customClass: {
                                    popup: 'rounded-xl',
                                    confirmButton: 'rounded-lg'
                                }
                            });
                        });
                    }
                });
            }

            function attachDeleteListeners() {
                document.querySelectorAll('.delete-btn').forEach(button => {
                    const newButton = button.cloneNode(true);
                    button.parentNode.replaceChild(newButton, button);
                    newButton.addEventListener('click', handleDeleteClick);
                });
            }

            function handlePaginationClick(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page');
                fetchVisitas(page);
            }

            function attachPaginationListeners() {
                paginationLinksContainer.querySelectorAll('a').forEach(link => {
                    const newLink = link.cloneNode(true);
                    link.parentNode.replaceChild(newLink, link);
                    newLink.addEventListener('click', handlePaginationClick);
                });
            }

            function fetchVisitas(page = 1) {
                const query = searchInput.value;
                const fechaInicio = filterFechaInicio.value;
                const fechaFin = filterFechaFin.value;
                const tipoVisitaId = filterTipoVisita.value;

                let url = `{{ route('visitas.index') }}?page=${page}&search=${encodeURIComponent(query)}`;
                if (fechaInicio) url += `&fecha_inicio=${encodeURIComponent(fechaInicio)}`;
                if (fechaFin) url += `&fecha_fin=${encodeURIComponent(fechaFin)}`;
                if (tipoVisitaId) url += `&tipo_visita_id=${encodeURIComponent(tipoVisitaId)}`;

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error en la respuesta del servidor');
                    return response.json();
                })
                .then(data => {
                    visitasTableBody.innerHTML = data.table_rows;
                    paginationLinksContainer.innerHTML = data.pagination_links;

                    if (data.table_rows.trim() === '') {
                        visitasTableBody.closest('table').style.display = 'none';
                        emptyState.classList.remove('hidden');
                    } else {
                        visitasTableBody.closest('table').style.display = 'table';
                        emptyState.classList.add('hidden');
                    }

                    attachDeleteListeners();
                    attachPaginationListeners();
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error de Conexión',
                        text: 'No se pudieron cargar las visitas. Por favor, intenta de nuevo.',
                        icon: 'error',
                        customClass: {
                            popup: 'rounded-xl',
                            confirmButton: 'rounded-lg'
                        }
                    });
                });
            }

            function getCurrentPage() {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get('page') || 1;
            }

            // --- FILTRADO AUTOMÁTICO ---

            // Event listeners para los filtros que llaman a fetchVisitas
            filterFechaInicio.addEventListener('change', () => fetchVisitas(1));
            filterFechaFin.addEventListener('change', () => fetchVisitas(1));
            filterTipoVisita.addEventListener('change', () => fetchVisitas(1));

            // Búsqueda general con retardo (debounce)
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => fetchVisitas(1), 500); // 500ms de espera
            });

            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    fetchVisitas(1);
                }
            });

            // --- FIN DE CAMBIOS ---

            attachDeleteListeners();
            attachPaginationListeners();
        });
    </script>
</x-app-layout>

