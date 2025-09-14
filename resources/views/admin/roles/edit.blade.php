<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <nav class="flex items-center space-x-2 text-sm font-medium">
                    <a href="{{ route('admin.roles.index') }}" class="text-indigo-600 hover:text-indigo-800 transition duration-200 flex items-center">
                        <i class="fas fa-user-shield mr-2"></i>
                        Roles
                    </a>
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-600 flex items-center">
                        <i class="fas fa-pencil-alt mr-2"></i>
                        Editar Rol
                    </span>
                </nav>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-pencil-alt text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-white">Editar Rol</h2>
                            <p class="text-indigo-100 text-sm mt-1">Modifica el nombre y los permisos asignados a este rol.</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-8">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-user-tag text-indigo-500 mr-1"></i>
                                Nombre del Rol
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $role->name) }}" 
                                       required 
                                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('name') border-red-300 ring-2 ring-red-200 @enderror"
                                       placeholder="Ej: Administrador, Editor, Visitante..."
                                       maxlength="50">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-id-badge text-gray-400"></i>
                                </div>
                            </div>
                            @error('name')
                            <p class="text-red-600 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                            <p class="text-gray-500 text-xs">El nombre debe ser único. Máximo 50 caracteres.</p>
                        </div>

                        <div class="space-y-4 pt-6 border-t border-gray-200">
                             <div>
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-key text-indigo-500 mr-2"></i>
                                    Permisos del Rol
                                </h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Actualiza los permisos asignados a este rol.
                                </p>
                             </div>

                             <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @forelse($permissions as $permission)
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-400 transition duration-200 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-500 has-[:checked]:ring-1 has-[:checked]:ring-indigo-500">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->name }}"
                                               {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                               class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-3 text-sm font-medium text-gray-800">{{ $permission->name }}</span>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-500 col-span-full bg-gray-50 p-4 rounded-lg text-center">
                                        <i class="fas fa-info-circle mr-2"></i>No hay permisos disponibles para asignar.
                                    </p>
                                @endforelse
                             </div>
                             @error('permissions')
                                <p class="text-red-600 text-sm flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                             @enderror
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row gap-3 pt-6 border-t border-gray-200 justify-end">
                            <a href="{{ route('admin.roles.index') }}" 
                               class="w-full sm:w-auto bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 flex items-center justify-center text-sm uppercase">
                                <i class="fas fa-times mr-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="w-full sm:w-auto bg-gradient-to-r from-indigo-600 to-indigo-500 text-white px-6 py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-indigo-600 transform hover:scale-105 transition duration-300 shadow-lg flex items-center justify-center text-sm uppercase">
                                <i class="fas fa-save mr-2"></i>
                                Actualizar Rol
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>