document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('visitas-container');
    if (!container) return;

    const baseUrl = container.dataset.url;
    const successAlert = document.getElementById('success-alert');
    const searchInput = document.getElementById('search-input');
    const visitasTableBody = document.getElementById('visitas-table-body');
    const paginationLinksContainer = document.getElementById('pagination-links');
    const emptyState = document.getElementById('empty-state');
    const filterFechaInicio = document.getElementById('filter-fecha-inicio');
    const filterFechaFin = document.getElementById('filter-fecha-fin');
    const filterTipoVisita = document.getElementById('filter-tipo-visita');
    let searchTimeout;

    if (successAlert) {
        setTimeout(() => successAlert.style.display = 'none', 5000);
    }

    function handleDeleteClick(e) {
        e.preventDefault();
        const form = this.closest('form');

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
                    method: 'POST',
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
                            customClass: { popup: 'rounded-xl' }
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
                        customClass: { popup: 'rounded-xl', confirmButton: 'rounded-lg' }
                    });
                });
            }
        });
    }

    function fetchVisitas(page = 1) {
        const query = searchInput.value;
        const fechaInicio = filterFechaInicio.value;
        const fechaFin = filterFechaFin.value;
        const tipoVisitaId = filterTipoVisita.value;

        let url = `${baseUrl}?page=${page}&search=${encodeURIComponent(query)}`;
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
            attachActionListeners();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error de Conexión',
                text: 'No se pudieron cargar las visitas. Por favor, intenta de nuevo.',
                icon: 'error',
                customClass: { popup: 'rounded-xl', confirmButton: 'rounded-lg' }
            });
        });
    }

    function getCurrentPage() {
        const activePageLink = paginationLinksContainer.querySelector('.pagination .active span');
        if (activePageLink) {
            return activePageLink.textContent;
        }
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('page') || 1;
    }
    
    function attachActionListeners() {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.removeEventListener('click', handleDeleteClick);
            button.addEventListener('click', handleDeleteClick);
        });

        paginationLinksContainer.querySelectorAll('a.page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page');
                fetchVisitas(page);
            });
        });
    }

    filterFechaInicio.addEventListener('change', () => fetchVisitas(1));
    filterFechaFin.addEventListener('change', () => fetchVisitas(1));
    filterTipoVisita.addEventListener('change', () => fetchVisitas(1));

    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => fetchVisitas(1), 500);
    });

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            fetchVisitas(1);
        }
    });
    
    attachActionListeners();
});