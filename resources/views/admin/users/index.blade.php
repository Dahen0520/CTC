<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-white text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-2xl font-bold text-white">Gestión de Usuarios</h1>
                            <p class="text-sm text-blue-100 mt-1">Administra los usuarios existentes y sus roles</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.create') }}" 
                       class="w-full md:w-auto inline-flex items-center justify-center px-5 py-3 bg-chorotega-yellow text-chorotega-blue font-semibold rounded-lg hover:bg-yellow-400 transform hover:scale-105 transition duration-200 shadow-lg whitespace-nowrap">
                        <i class="fas fa-plus mr-2"></i>
                        Crear Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>

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
                                    <i class="fas fa-user text-gray-400"></i>
                                    <span>Nombre</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                    <span>Email</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-user-tag text-gray-400"></i>
                                    <span>Roles</span>
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
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-chorotega-blue flex items-center justify-center">
                                                <span class="text-white text-sm font-medium">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            @if(auth()->id() === $user->id)
                                                <div class="text-xs text-gray-500">(Tú)</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                @if($role->name === 'admin')
                                                    <i class="fas fa-shield-alt mr-1"></i>
                                                @else
                                                    <i class="fas fa-user-tag mr-1"></i>
                                                @endif
                                                {{ $role->name }}
                                            </span>
                                        @empty
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                <i class="fas fa-user-minus mr-1"></i>
                                                Sin rol
                                            </span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-3">
                                        @if($user->email === 'admin@dahen.dev')
                                            <span class="inline-flex items-center px-3 py-1 text-xs bg-gray-100 text-gray-500 rounded-full">
                                                <i class="fas fa-lock mr-1"></i>
                                                Bloqueado
                                            </span>
                                        @else
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="inline-flex items-center px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition-colors duration-150">
                                                <i class="fas fa-edit mr-1"></i>
                                                Editar
                                            </a>
                                            
                                            @if(auth()->id() !== $user->id)
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-block delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors duration-150">
                                                        <i class="fas fa-trash-alt mr-1"></i>
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-12">
                                    <div class="max-w-md mx-auto">
                                        <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-users text-gray-400 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron usuarios</h3>
                                        <p class="text-gray-500 mb-6">Comienza creando tu primer usuario del sistema.</p>
                                        <a href="{{ route('admin.users.create') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-chorotega-blue text-white rounded-lg hover:bg-chorotega-blue-light transition duration-200">
                                            <i class="fas fa-plus mr-2"></i>
                                            Crear Primer Usuario
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