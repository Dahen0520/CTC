<x-app-layout>
    <x-slot name="header">
        Perfil de Usuario
    </x-slot>

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6 py-8">
        
        {{-- Tarjeta de bienvenida --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-start space-x-6">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-2xl font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </span>
                    </div>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">¡Hola, {{ auth()->user()->name }}!</h1>
                    <p class="text-gray-600 mb-4">Desde aquí puedes gestionar tu información personal y configurar la seguridad de tu cuenta.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Miembro desde {{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Información Personal --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300 profile-section">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Información Personal</h2>
                            <p class="text-sm text-gray-600">Actualiza tus datos básicos</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Seguridad --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300 profile-section">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-lock text-green-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Seguridad</h2>
                            <p class="text-sm text-gray-600">Cambia tu contraseña</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>

        {{-- Información adicional --}}
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-amber-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-amber-800 mb-1">Información importante</h3>
                    <p class="text-sm text-amber-700">
                        Tu información personal está protegida y solo tú puedes modificarla. Si tienes problemas para actualizar tus datos, contacta al administrador del sistema.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>