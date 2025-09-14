<div class="flex flex-col h-full">
<div class="flex justify-center mt-0 mb-2 px-4">
<a href="{{ route('dashboard') }}">
<img src="{{ asset('assets/imgs/ctc_b.png') }}"
alt="Logo de Cooperativa Chorotega"
class="h-12 lg:h-14 mt-4 mb-2 max-w-full">
</a>
</div>

<nav class="flex flex-col px-4 space-y-2 flex-1 overflow-y-auto">
    {{-- Inicio --}}
    <!--<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
        class="py-3 px-4 rounded hover:bg-chorotega-blue-light hover:text-yellow-400 transition duration-200 ease-in-out text-white flex items-center text-sm lg:text-base">
        <i class="fas fa-home mr-3 text-base"></i>
        {{ __('Inicio') }}
    </x-nav-link>-->

    {{-- Búsqueda de Afiliado  --}}
    
    <!--<x-nav-link :href="route('busqueda.index')" :active="request()->routeIs('busqueda.index')"
        class="py-3 px-4 rounded hover:bg-chorotega-blue-light hover:text-yellow-400 transition duration-200 ease-in-out text-white flex items-center text-sm lg:text-base">
        <i class="fas fa-search mr-3 text-base"></i>
        {{ __('Búsqueda de Afiliado') }}
    </x-nav-link>-->

    {{-- Gestión de Tipos de Visita --}}
    @can('viewAny', App\Models\TipoVisita::class)
    <x-nav-link :href="route('tipo-visitas.index')" :active="request()->routeIs('tipo-visitas.index')"
        class="py-3 px-4 rounded hover:bg-chorotega-blue-light hover:text-yellow-400 transition duration-200 ease-in-out text-white flex items-center text-sm lg:text-base">
        <i class="fas fa-eye mr-3 text-base"></i>
        {{ __('Gestión de Tipos de Visita') }}
    </x-nav-link>
    @endcan

    {{-- Gestión de Visitas --}}
    @can('viewAny', App\Models\Visita::class)
    <x-nav-link :href="route('visitas.index')" :active="request()->routeIs('visitas.index')"
        class="py-3 px-4 rounded hover:bg-chorotega-blue-light hover:text-yellow-400 transition duration-200 ease-in-out text-white flex items-center text-sm lg:text-base">
        <i class="fas fa-clipboard-check mr-3 text-base"></i>
        {{ __('Gestión de Visitas') }}
    </x-nav-link>
    @endcan

    {{-- Registrar Visita (Nueva opción) --}}
    @can('create', App\Models\Visita::class)
    <x-nav-link :href="route('visitas.registrar')" :active="request()->routeIs('visitas.registrar')"
        class="py-3 px-4 rounded hover:bg-chorotega-blue-light hover:text-yellow-400 transition duration-200 ease-in-out text-white flex items-center text-sm lg:text-base">
        <i class="fas fa-plus-square mr-3 text-base"></i>
        {{ __('Registrar Visita') }}
    </x-nav-link>
    @endcan
        {{-- SECCIÓN DE ADMINISTRACIÓN --}}
    @hasrole('admin')
    <div class="pt-4 pb-2">
        <h3 class="px-4 text-xs font-semibold uppercase text-gray-400 tracking-wider">Administración</h3>
    </div>
    
    {{-- Gestión de Roles --}}
    <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')"
        class="py-3 px-4 rounded hover:bg-chorotega-blue-light hover:text-yellow-400 transition duration-200 ease-in-out text-white flex items-center text-sm lg:text-base">
        <i class="fas fa-user-shield mr-3 text-base"></i>
        {{ __('Gestión de Roles') }}
    </x-nav-link>
    
       {{-- Gestión de Usuarios (NUEVO) --}}
    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')"         
        class="py-3 px-4 rounded hover:bg-chorotega-blue-light hover:text-yellow-400 transition duration-200 ease-in-out text-white flex items-center text-sm lg:text-base">
        <i class="fas fa-users-cog mr-3 text-base"></i>
        {{ __('Gestión de Usuarios') }}
    </x-nav-link>
    @endhasrole
</nav>

</div>