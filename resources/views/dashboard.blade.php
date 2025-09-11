<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <a href="{{ route('visitas.registrar') }}" 
                   class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl overflow-hidden
                          transform hover:-translate-y-1 transition-all duration-300">
                    
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-chorotega-blue to-blue-600 
                                        rounded-xl flex items-center justify-center shadow-md 
                                        group-hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-clipboard-list text-white text-2xl"></i>
                            </div>

                            <div class="ml-5">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                    Registrar Visita
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Crea un nuevo registro de entrada.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-3">
                        <div class="text-sm font-medium text-chorotega-blue group-hover:text-blue-700 flex items-center justify-end">
                            <span>Acceder</span>
                            <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>