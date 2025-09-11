document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('tipo-visitas-container');
    if (!container) return; 

    const successAlert = document.getElementById('success-alert');
    const searchInput = document.getElementById('search-input');
    const tipoVisitasTableBody = document.getElementById('tipo-visitas-table-body');
    const paginationLinksContainer = document.getElementById('pagination-links');
    const emptyState = document.getElementById('empty-state');

    const baseUrl = container.dataset.url;
    let searchTimeout;

    // Ocultar la alerta de éxito después de 5 segundos
    if (successAlert) {
        setTimeout(() => successAlert.style.display = 'none', 5000);
    }

    // --- FUNCIONES ---

    function handleDeleteClick(e) {
        e.preventDefault();
        const form = this.closest('form');
        const tipoVisitaNombre = this.getAttribute('data-nombre');

        Swal.fire({
            title: '¿Eliminar tipo de visita?',
            text: `¿Estás seguro de que deseas eliminar "${tipoVisitaNombre}"?`,
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
                        fetchTipoVisitas(getCurrentPage());
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

    function fetchTipoVisitas(page = 1) {
        const query = searchInput.value;
        const url = `${baseUrl}?page=${page}&search=${encodeURIComponent(query)}`;

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
            tipoVisitasTableBody.innerHTML = data.table_rows;
            paginationLinksContainer.innerHTML = data.pagination_links;

            if (data.table_rows.trim() === '') {
                tipoVisitasTableBody.closest('table').style.display = 'none';
                emptyState.classList.remove('hidden');
            } else {
                tipoVisitasTableBody.closest('table').style.display = 'table';
                emptyState.classList.add('hidden');
            }

            attachActionListeners();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error de Conexión',
                text: 'No se pudieron cargar los datos. Por favor, intenta de nuevo.',
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
                fetchTipoVisitas(page);
            });
        });
    }

    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => fetchTipoVisitas(1), 300);
    });

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            fetchTipoVisitas(1);
        }
    });

    attachActionListeners();
});