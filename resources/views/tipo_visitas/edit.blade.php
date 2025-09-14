<x-app-layout>
    <x-slot name="header">
        Editar Tipo de Visita
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('tipo-visitas.index') }}" class="text-chorotega-blue hover:text-chorotega-blue-light transition duration-200 flex items-center">
                    <i class="fas fa-eye mr-1"></i>
                    Tipos de Visita
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-600 flex items-center">
                    <i class="fas fa-edit mr-1"></i>
                    Editar
                </span>
            </nav>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-edit text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold text-white">Editar Tipo de Visita</h2>
                        <p class="text-blue-100 text-sm mt-1">Actualiza la información del tipo de visita existente</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Hay errores en el formulario</h3>
                        </div>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @cannot('update', $tipoVisita)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lock text-yellow-600"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Modo de solo lectura</h3>
                            <p class="text-sm text-yellow-700 mt-1">No tienes permiso para editar este registro.</p>
                        </div>
                    </div>
                </div>
                @endcannot

                <form method="POST" action="{{ route('tipo-visitas.update', $tipoVisita) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-2">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-tag text-chorotega-blue mr-1"></i>
                            Nombre del Tipo de Visita
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre', $tipoVisita->nombre) }}" 
                                   required 
                                   @cannot('update', $tipoVisita) disabled @endcannot
                                   class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-chorotega-blue focus:border-transparent transition duration-200 @error('nombre') border-red-300 ring-2 ring-red-200 @enderror disabled:bg-gray-100"
                                   placeholder="Ej: Visita médica, Visita de trabajo..."
                                   maxlength="100">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-edit text-gray-400"></i>
                            </div>
                        </div>
                        @error('nombre')
                        <p class="text-red-600 text-sm flex items-center mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Máximo 100 caracteres</p>
                    </div>

                    <div class="space-y-2">
                        <label for="precio" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-dollar-sign text-chorotega-blue mr-1"></i>
                            Precio
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   id="precio" 
                                   name="precio" 
                                   value="{{ old('precio', $tipoVisita->precio) }}" 
                                   required 
                                   step="0.01"
                                   @cannot('update', $tipoVisita) disabled @endcannot
                                   class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-chorotega-blue focus:border-transparent transition duration-200 @error('precio') border-red-300 ring-2 ring-red-200 @enderror disabled:bg-gray-100"
                                   placeholder="Ej: 50.00">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-dollar-sign text-gray-400"></i>
                            </div>
                        </div>
                        @error('precio')
                        <p class="text-red-600 text-sm flex items-center mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Ingresa el precio en Lempiras, con hasta dos decimales.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-toggle-on text-chorotega-blue mr-1"></i>
                            Estado
                        </label>
                        <div class="flex items-center space-x-6">
                            <label for="estado_activo" class="flex items-center cursor-pointer">
                                <input type="radio" 
                                       id="estado_activo" 
                                       name="estado" 
                                       value="activo" 
                                       @cannot('update', $tipoVisita) disabled @endcannot
                                       class="h-4 w-4 text-chorotega-blue focus:ring-chorotega-blue-light border-gray-300"
                                       {{ old('estado', $tipoVisita->estado) == 'activo' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Activo</span>
                            </label>
                            <label for="estado_inactivo" class="flex items-center cursor-pointer">
                                <input type="radio" 
                                       id="estado_inactivo" 
                                       name="estado" 
                                       value="inactivo" 
                                       @cannot('update', $tipoVisita) disabled @endcannot
                                       class="h-4 w-4 text-chorotega-blue focus:ring-chorotega-blue-light border-gray-300"
                                       {{ old('estado', $tipoVisita->estado) == 'inactivo' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Inactivo</span>
                            </label>
                        </div>
                        @error('estado')
                        <p class="text-red-600 text-sm flex items-center mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-blue-800">Información importante</h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    Asegúrate de que el precio sea un valor numérico válido.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        @can('update', $tipoVisita)
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light text-white px-6 py-3 rounded-lg font-semibold hover:from-chorotega-blue-light hover:to-chorotega-blue transform hover:scale-105 transition duration-200 shadow-lg flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Actualizar Tipo de Visita
                        </button>
                        @endcan
                        
                        <a href="{{ route('tipo-visitas.index') }}" 
                           class="flex-1 sm:flex-initial bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-lightbulb text-chorotega-yellow mr-2"></i>
                Tips para editar tipos de visita efectivos
            </h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Mantén la brevedad y concisión, pero no sacrifiques la claridad</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Verifica que el precio sea exacto y no contenga caracteres inválidos</span>
                </li>
            </ul>
        </div>
    </div>
</x-app-layout>