<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Reservas Chorotega') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'chorotega-blue': '#2c3991',
                        'chorotega-yellow': '#f5b800',
                        'bg-light-gray': '#edf0fa',
                        'chorotega-blue-light': '#3a4aab',
                    },
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>[x-cloak] { display: none !important; }</style>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body class="bg-bg-light-gray min-h-screen">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        <!-- Sidebar Desktop -->
        <aside class="hidden lg:flex bg-chorotega-blue text-white w-56 min-h-screen fixed top-0 left-0 flex-col z-50 shadow-md">
            @include('partials.sidebar')
        </aside>

        <!-- Sidebar Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden" x-cloak></div>
        
        <aside x-show="sidebarOpen" @click.away="sidebarOpen = false" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="bg-chorotega-blue text-white w-64 min-h-screen fixed top-0 left-0 flex flex-col z-50 shadow-md lg:hidden" x-cloak>
            @include('partials.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-56 flex flex-col min-h-screen">
            <!-- Top Header -->
            <div class="sticky top-0 z-30 bg-white shadow">
                @include('partials.top-header')
            </div>

            <!-- Main Content Area -->
            <main class="p-4 lg:p-6 flex-1 overflow-y-auto flex flex-col justify-between">
                <div id="contenido" class="mb-8">
                    @isset($header)
                        <h2 class="text-xl lg:text-2xl font-bold text-chorotega-blue mb-4 text-center">{{ $header }}</h2>
                    @else
                        <h2 class="text-xl lg:text-2xl font-bold text-chorotega-blue mb-4 text-center">Bienvenido al sistema</h2>
                    @endisset
                    
                    {{ $slot }}
                </div>
                
                <!-- Footer -->
                <footer class="text-xs lg:text-sm text-center text-gray-500 border-t pt-4">
                    <p>&copy; <span id="year"></span> Cooperativa Chorotega. Todos los derechos reservados. devDahen</p>
                </footer>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const yearSpan = document.getElementById("year");
            if (yearSpan) yearSpan.textContent = new Date().getFullYear();
        });
    </script>
</body>
</html>