<x-app-layout>
    <x-slot name="header">
        Editar Visita
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('visitas.index') }}" class="text-chorotega-blue hover:text-chorotega-blue-light transition duration-200 flex items-center">
                    <i class="fas fa-eye mr-1"></i>
                    Visitas
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
                        <h2 class="text-xl font-bold text-white">Editar Visita</h2>
                        <p class="text-blue-100 text-sm mt-1">Actualiza la información de la visita existente</p>
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

                <form method="POST" action="{{ route('visitas.update', $visita) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="tipo_visita_id" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-tag text-chorotega-blue mr-1"></i>
                            Tipo de Visita
                        </label>
                        <select id="tipo_visita_id" name="tipo_visita_id" required 
                                class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-chorotega-blue focus:border-transparent transition duration-200 @error('tipo_visita_id') border-red-300 ring-2 ring-red-200 @enderror">
                            <option value="">Selecciona un tipo de visita</option>
                            @foreach($tiposVisita as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_visita_id', $visita->tipo_visita_id) == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_visita_id')
                        <p class="text-red-600 text-sm flex items-center mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-calendar-alt text-chorotega-blue mr-1"></i>
                            Fecha
                        </label>
                        <input type="date" id="fecha" name="fecha" value="{{ old('fecha', $visita->fecha) }}" required
                            class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-chorotega-blue focus:border-transparent transition duration-200 @error('fecha') border-red-300 ring-2 ring-red-200 @enderror">
                        @error('fecha')
                        <p class="text-red-600 text-sm flex items-center mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="numero_identidad" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-id-card text-chorotega-blue mr-1"></i>
                            Número de Identidad (Opcional)
                        </label>
                        <input type="text" id="numero_identidad" name="numero_identidad" value="{{ old('numero_identidad', $visita->numero_identidad) }}"
                            class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-chorotega-blue focus:border-transparent transition duration-200 @error('numero_identidad') border-red-300 ring-2 ring-red-200 @enderror">
                        @error('numero_identidad')
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
                                    Asegúrate de que los datos de la visita sean correctos.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light text-white px-6 py-3 rounded-lg font-semibold hover:from-chorotega-blue-light hover:to-chorotega-blue transform hover:scale-105 transition duration-200 shadow-lg flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Actualizar Visita
                        </button>
                        
                        <a href="{{ route('visitas.index') }}" 
                           class="flex-1 sm:flex-initial bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>