<!-- partials/top-header.blade.php -->
<header class="bg-white border-b border-gray-200 px-4 lg:px-6 py-3 lg:py-4 flex justify-between items-center">
    <div class="flex items-center">
        <!-- Mobile Menu Button -->
        <button @click="sidebarOpen = !sidebarOpen" 
                class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 mr-3">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- App Name/Logo -->
        <div class="text-base lg:text-lg font-semibold text-chorotega-blue">
            <span class="hidden sm:inline">{{ config('app.name', 'Reservas Chorotega') }}</span>
            <span class="sm:hidden">Chorotega</span>
        </div>
    </div>

    <!-- User Menu -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
            <img class="h-8 w-8 rounded-full object-cover mr-2"
                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2c3991&color=fff"
                 alt="Foto de perfil">
            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
            <span class="sm:hidden">{{ substr(Auth::user()->name, 0, 1) }}</span>
            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                      clip-rule="evenodd" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" @click.away="open = false" x-transition x-cloak
             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
            
            <!-- User Info (mobile only) -->
            <div class="sm:hidden px-4 py-2 border-b border-gray-100">
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>

            <!-- Profile Link -->
            <a href="{{ route('profile.edit') }}"
               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                <i class="fas fa-user-circle mr-2 text-gray-400"></i>
                {{ __('Mi Perfil') }}
            </a>

            <!-- Settings (if available) -->
            @can('access-settings')
            <a href="{{ route('settings.index') }}"
               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                <i class="fas fa-cog mr-2 text-gray-400"></i>
                {{ __('Configuración') }}
            </a>
            @endcan

            <!-- Divider -->
            <div class="border-t border-gray-100"></div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                    <i class="fas fa-sign-out-alt mr-2 text-gray-400"></i>
                    {{ __('Cerrar Sesión') }}
                </button>
            </form>
        </div>
    </div>
</header>