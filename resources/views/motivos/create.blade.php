<x-app-layout>
    <x-slot name="header">
        Crear Nuevo Motivo
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Breadcrumb y navegación --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('motivos.index') }}" class="text-chorotega-blue hover:text-chorotega-blue-light transition duration-200 flex items-center">
                    <i class="fas fa-clipboard-list mr-1"></i>
                    Motivos
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-600 flex items-center">
                    <i class="fas fa-plus mr-1"></i>
                    Crear Nuevo
                </span>
            </nav>
        </div>

        {{-- Formulario principal --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            {{-- Header del formulario --}}
            <div class="bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold text-white">Crear Nuevo Motivo de Visita</h2>
                        <p class="text-blue-100 text-sm mt-1">Completa la información para agregar un nuevo motivo de visita</p>
                    </div>
                </div>
            </div>

            {{-- Contenido del formulario --}}
            <div class="p-6">
                {{-- Mensajes de error --}}
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

                <form method="POST" action="{{ route('motivos.store') }}" class="space-y-6">
                    @csrf
                    
                    {{-- Campo de nombre --}}
                    <div class="space-y-2">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-tag text-chorotega-blue mr-1"></i>
                            Nombre del Motivo
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required 
                                   class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-chorotega-blue focus:border-transparent transition duration-200 @error('nombre') border-red-300 ring-2 ring-red-200 @enderror"
                                   placeholder="Ej: Consulta médica, Reunión de trabajo..."
                                   maxlength="100">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-edit text-gray-400"></i>
                            </div>
                        </div>
                        @error('nombre')
                        <p class="text-red-600 text-sm flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Máximo 100 caracteres</p>
                    </div>

                    {{-- Información adicional --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-blue-800">Información importante</h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    El motivo que crees estará disponible para ser seleccionado en el sistema. 
                                    Asegúrate de que el nombre sea claro y descriptivo.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light text-white px-6 py-3 rounded-lg font-semibold hover:from-chorotega-blue-light hover:to-chorotega-blue transform hover:scale-105 transition duration-200 shadow-lg flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Guardar Motivo
                        </button>
                        
                        <a href="{{ route('motivos.index') }}" 
                           class="flex-1 sm:flex-initial bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tips y ayuda --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-lightbulb text-chorotega-yellow mr-2"></i>
                Tips para crear motivos efectivos
            </h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Usa nombres claros y descriptivos que los usuarios puedan entender fácilmente</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Evita abreviaciones o términos técnicos complicados</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Mantén la consistencia con otros motivos existentes en el sistema</span>
                </li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nombreInput = document.getElementById('nombre');
            
            // Auto-focus en el campo de nombre
            nombreInput.focus();
            
            // Validación en tiempo real
            nombreInput.addEventListener('input', function() {
                const value = this.value.trim();
                const maxLength = 100;
                
                // Actualizar contador de caracteres
                const remaining = maxLength - value.length;
                const helperText = this.parentElement.nextElementSibling.nextElementSibling;
                
                if (remaining < 20) {
                    helperText.textContent = `${remaining} caracteres restantes`;
                    helperText.className = remaining < 10 ? 'text-red-500 text-xs' : 'text-yellow-600 text-xs';
                } else {
                    helperText.textContent = 'Máximo 100 caracteres';
                    helperText.className = 'text-gray-500 text-xs';
                }
            });
        });
    </script>
</x-app-layout>