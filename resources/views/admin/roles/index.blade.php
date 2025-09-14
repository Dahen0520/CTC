<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-shield text-white text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-2xl font-bold text-white">Gestión de Roles</h1>
                            <p class="text-sm text-blue-100 mt-1">Administra los roles y permisos del sistema</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.roles.create') }}" 
                       class="w-full md:w-auto inline-flex items-center justify-center px-5 py-3 bg-chorotega-yellow text-chorotega-blue font-semibold rounded-lg hover:bg-yellow-400 transform hover:scale-105 transition duration-200 shadow-lg whitespace-nowrap">
                        <i class="fas fa-plus mr-2"></i>
                        Crear Nuevo Rol
                    </a>
                </div>
            </div>
        </div>

        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
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

        @if(session('error'))
        <div id="error-alert" class="bg-white rounded-lg shadow-sm border border-red-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-white text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-white font-medium">¡Oops! Ha ocurrido un error</p>
                        <p class="text-red-100 text-sm">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.style.display='none'" 
                            class="ml-auto flex-shrink-0 text-red-100 hover:text-white">
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
                                    <span>ID</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-tag text-gray-400"></i>
                                    <span>Nombre del Rol</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center justify-center space-x-1">
                                    <i class="fas fa-cogs text-gray-400"></i>
                                    <span>Acciones</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($roles as $role)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="font-mono bg-gray-100 px-2 py-1 rounded text-xs">{{ $role->id }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">{{ $role->name }}</div>
                                        @if ($role->name === 'admin')
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-shield-alt mr-1"></i>
                                                Sistema
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('admin.roles.edit', $role) }}" 
                                           class="inline-flex items-center px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition-colors duration-150">
                                            <i class="fas fa-edit mr-1"></i>
                                            Editar
                                        </a>
                                        
                                        @if ($role->name !== 'admin')
                                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="inline-block delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors duration-150">
                                                <i class="fas fa-trash-alt mr-1"></i>
                                                Eliminar
                                            </button>
                                        </form>
                                        @else
                                        <span class="inline-flex items-center px-3 py-1 text-xs bg-gray-100 text-gray-500 rounded-full cursor-not-allowed">
                                            <i class="fas fa-lock mr-1"></i>
                                            Protegido
                                        </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-12">
                                    <div class="max-w-md mx-auto">
                                        <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-user-shield text-gray-400 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron roles</h3>
                                        <p class="text-gray-500 mb-6">Comienza creando tu primer rol del sistema.</p>
                                        <a href="{{ route('admin.roles.create') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-chorotega-blue text-white rounded-lg hover:bg-chorotega-blue-light transition duration-200">
                                            <i class="fas fa-plus mr-2"></i>
                                            Crear Primer Rol
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Script para confirmación de borrado --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esta acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                });
            });
        });
    </script>
</x-app-layout>