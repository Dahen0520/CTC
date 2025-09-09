{{-- resources/views/busqueda/afiliado.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        Consulta de Afiliados
    </x-slot>

    <div class="space-y-6">
        {{-- Formulario de Búsqueda --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-search text-white text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-white">Consultar Afiliado por DNI</h3>
                        <p class="text-sm text-blue-100">Ingrese el número de identificación del afiliado</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <form action="{{ route('busqueda.buscar') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div class="md:col-span-2">
                            <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-id-card mr-1 text-chorotega-blue"></i>
                                Número de Identificación
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-chorotega-blue focus:border-transparent transition duration-200 text-gray-900 placeholder-gray-500" 
                                   id="dni" 
                                   name="dni" 
                                   placeholder="Ej: 0801199812345"
                                   value="{{ old('dni') }}"
                                   required>
                        </div>
                        <div>
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-chorotega-blue to-chorotega-blue-light text-white px-6 py-3 rounded-lg hover:from-chorotega-blue-light hover:to-chorotega-blue transform hover:scale-105 transition duration-200 shadow-lg flex items-center justify-center">
                                <i class="fas fa-search mr-2"></i>
                                Consultar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Resultados --}}
        @isset($afiliado)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            {{-- Header de Resultados --}}
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-check text-white text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-white">Datos del Afiliado</h3>
                            <p class="text-sm text-green-100">Información encontrada exitosamente</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        <span class="text-white text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i>
                            Activo
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                {{-- Información Personal --}}
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user text-chorotega-blue mr-2"></i>
                        Información Personal
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm font-medium text-gray-900">{{ $afiliado['nombre_afiliado'] }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Persona</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">{{ $afiliado['tipo_persona'] }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Género</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">{{ $afiliado['genero'] }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Profesión</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">{{ $afiliado['profesion'] }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Nacimiento</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">
                                    <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                    {{ \Carbon\Carbon::parse($afiliado['fecha_de_nacimiento'])->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">
                                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                                    {{ $afiliado['telefono'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información de Afiliación --}}
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-id-badge text-chorotega-blue mr-2"></i>
                        Información de Afiliación
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Número de Afiliación</label>
                            <div class="bg-chorotega-blue bg-opacity-10 rounded-lg p-3 border-2 border-chorotega-blue border-opacity-20">
                                <p class="text-sm font-bold text-chorotega-blue">{{ $afiliado['numero_afiliacion'] }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Afiliación</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">
                                    <i class="fas fa-calendar-plus text-gray-400 mr-2"></i>
                                    {{ \Carbon\Carbon::parse($afiliado['fecha_afiliacion'])->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Filial</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">{{ $afiliado['filial'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información de Contacto --}}
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-envelope text-chorotega-blue mr-2"></i>
                        Información de Contacto
                    </h4>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Correo Electrónico</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">
                                    <i class="fas fa-at text-gray-400 mr-2"></i>
                                    {{ $afiliado['correo_electronico'] }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección Principal</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                    {{ $afiliado['direccion_principal'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información Geográfica --}}
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-map text-chorotega-blue mr-2"></i>
                        Ubicación Geográfica
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">{{ $afiliado['nombre_departamento'] }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Municipio</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">{{ $afiliado['nombre_municipio'] }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Barrio</label>
                            <div class="bg-gray-50 rounded-lg p-3 border">
                                <p class="text-sm text-gray-900">{{ $afiliado['nombre_barrio'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="window.print()" 
                                class="flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                            <i class="fas fa-print mr-2"></i>
                            Imprimir
                        </button>
                        
                        <button onclick="copyToClipboard()" 
                                class="flex items-center justify-center px-4 py-2 bg-chorotega-yellow text-white rounded-lg hover:bg-yellow-600 transition duration-200">
                            <i class="fas fa-copy mr-2"></i>
                            Copiar Datos
                        </button>
                        
                        <a href="{{ route('busqueda.index') }}" 
                           class="flex items-center justify-center px-4 py-2 bg-chorotega-blue text-white rounded-lg hover:bg-chorotega-blue-light transition duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Nueva Búsqueda
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        {{-- Error --}}
        @isset($error)
        <div class="bg-white rounded-lg shadow-sm border border-red-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-white">No se encontraron resultados</h3>
                        <p class="text-sm text-red-100">El DNI ingresado no está registrado en el sistema</p>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <p class="text-gray-600">{{ $error }}</p>
                <div class="mt-4">
                    <a href="{{ route('busqueda.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                        <i class="fas fa-redo mr-2"></i>
                        Intentar nuevamente
                    </a>
                </div>
            </div>
        </div>
        @endisset
    </div>

    <script>
        function copyToClipboard() {
            const data = `
Nombre: {{ $afiliado['nombre_afiliado'] ?? '' }}
Número de Afiliación: {{ $afiliado['numero_afiliacion'] ?? '' }}
DNI: {{ request('dni') }}
Teléfono: {{ $afiliado['telefono'] ?? '' }}
Correo: {{ $afiliado['correo_electronico'] ?? '' }}
            `.trim();
            
            navigator.clipboard.writeText(data).then(() => {
                // Mostrar notificación de éxito
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.innerHTML = '<i class="fas fa-check mr-2"></i>Datos copiados al portapapeles';
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            });
        }
    </script>
</x-app-layout>