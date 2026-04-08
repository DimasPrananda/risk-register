@if(Auth::user()->usertype === 'admin' || Auth::user()->usertype === 'manager')
<div x-data="{ open: false }"
    :class="sidebarOpen ? ' w-40 md:w-64' : 'w-0 md:w-20'"
    class="hidden md:block fixed inset-y-0 left-0 z-50 bg-white dark:bg-gray-800 transition-all duration-300">
        {{-- TOGGLE SIDEBAR --}}
    <button
        @click="sidebarOpen = !sidebarOpen"
        class="w-full h-16 flex items-center px-6
            hover:bg-gray-100 dark:hover:bg-gray-700
            group"
    >
        {{-- LIGHT MODE --}}
        <img
            src="{{ asset('icons/xbox-menu-blue.svg') }}"
            class="block w-6 h-6 shrink-0 dark:hidden group-hover:hidden"
            alt="menu light"
        >
        <img
            src="{{ asset('icons/xbox-menu-white.svg') }}"
            class="hidden w-6 h-6 shrink-0 dark:hidden group-hover:block"
            alt="menu light hover"
        >

        {{-- DARK MODE --}}
        <img
            src="{{ asset('icons/xbox-menu-white.svg') }}"
            class="hidden w-6 h-6 shrink-0 dark:block group-hover:hidden"
            alt="menu dark"
        >

        <span
            x-show="sidebarOpen"
            x-transition
            class=" ml-2 md:ml-4 text-sm md:text-base md:font-medium text-gray-700 dark:text-gray-200"
        >
            Menu
        </span>
    </button>

    <x-side-link
        :href="route('admin.dashboard')"
        :active="request()->routeIs('admin.dashboard')"
        class="group items-center h-14 px-6"
    >
        @if(request()->routeIs('admin.dashboard'))
            {{-- ACTIVE ICON (GLOBAL) --}}
            <img
                src="{{ asset('icons/home_white.svg') }}"
                class="block w-6 h-6 shrink-0"
                alt="icon active"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class=" ml-2 md:ml-4 text-sm md:text-base whitespace-nowrap text-gray-700 dark:text-gray-200"
            >
                Dashboard
            </span>
        @else
            {{-- LIGHT MODE --}}
            <img
                src="{{ asset('icons/home_blue.svg') }}"
                class="block w-6 h-6 shrink-0 dark:hidden group-hover:hidden"
                alt="icon light"
            >
            <img
                src="{{ asset('icons/home_white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:hidden group-hover:block"
                alt="icon light hover"
            >

            {{-- DARK MODE --}}
            <img
                src="{{ asset('icons/home_white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:block group-hover:hidden"
                alt="icon dark"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-2 md:ml-4 text-sm md:text-base whitespace-nowrap text-gray-700 dark:text-gray-200"
            >
                Dashboard
            </span>
        @endif
    </x-side-link>
    <x-side-link
        :href="route('admin.user')"
        :active="request()->routeIs('admin.user')"
        class="group items-center h-14 px-6"
    >
        @if(request()->routeIs('admin.user'))
            {{-- ACTIVE ICON (GLOBAL) --}}
            <img
                src="{{ asset('icons/admin-settings-male-white.svg') }}"
                class="block w-6 h-6 shrink-0"
                alt="icon active"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-2 md:ml-4 text-sm md:text-base whitespace-nowrap text-gray-700 dark:text-gray-200"
            >
                User Management
            </span>
        @else
            {{-- LIGHT MODE --}}
            <img
                src="{{ asset('icons/admin-settings-male-blue.svg') }}"
                class="block w-6 h-6 shrink-0 dark:hidden group-hover:hidden"
                alt="icon light"
            >
            <img
                src="{{ asset('icons/admin-settings-male-white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:hidden group-hover:block"
                alt="icon light hover"
            >

            {{-- DARK MODE --}}
            <img
                src="{{ asset('icons/admin-settings-male-white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:block group-hover:hidden"
                alt="icon dark"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-2 md:ml-4 text-sm md:text-base whitespace-nowrap text-gray-700 dark:text-gray-200">
                User Management
            </span>
        @endif
    </x-side-link>
    <x-side-link
        :href="route('admin.departemen')"
        :active="request()->routeIs('admin.departemen')"
        class="group h-14 px-6 items-center"
    >
        @if(request()->routeIs('admin.departemen'))
            {{-- ACTIVE ICON (GLOBAL) --}}
            <img
                src="{{ asset('icons/building_white.svg') }}"
                class="block w-6 h-6 shrink-0"
                alt="icon active"
            >

            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                Departemen
            </span>
        @else
            {{-- LIGHT MODE --}}
            <img
                src="{{ asset('icons/building_blue.svg') }}"
                class="block w-6 h-6 shrink-0 dark:hidden group-hover:hidden"
                alt="icon light"
            >
            <img
                src="{{ asset('icons/building_white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:hidden group-hover:block"
                alt="icon light hover"
            >

            {{-- DARK MODE --}}
            <img
                src="{{ asset('icons/building_white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:block group-hover:hidden"
                alt="icon dark"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                Departemen
            </span>
        @endif
    </x-side-link>
    <x-side-link
        :href="route('admin.taksonomi')"
        :active="request()->routeIs('admin.taksonomi')"
        class="group items-center h-14 px-6"
    >
        @if(request()->routeIs('admin.taksonomi'))
            {{-- ACTIVE ICON (GLOBAL) --}}
            <img
                src="{{ asset('icons/categorize_white.svg') }}"
                class="block w-6 h-6 shrink-0"
                alt="icon active"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                Taksonomi Risiko
            </span>
        @else
            {{-- LIGHT MODE --}}
            <img
                src="{{ asset('icons/categorize_blue.svg') }}"
                class="block w-6 h-6 shrink-0 dark:hidden group-hover:hidden"
                alt="icon light"
            >
            <img
                src="{{ asset('icons/categorize_white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:hidden group-hover:block"
                alt="icon light hover"
            >

            {{-- DARK MODE --}}
            <img
                src="{{ asset('icons/categorize_white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:block group-hover:hidden"
                alt="icon dark"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                Taksonomi Risiko
            </span>
        @endif
    </x-side-link>
    <x-side-link
        :href="route('admin.periode')"
        :active="request()->routeIs('admin.periode')"
        class="group items-center h-14 px-6"
    >
        @if(request()->routeIs('admin.periode'))
            {{-- ACTIVE ICON (GLOBAL) --}}
            <img
                src="{{ asset('icons/timesheet_white.svg') }}"
                class="block w-6 h-6 shrink-0"
                alt="icon active"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                Periode
            </span>
        @else
            {{-- LIGHT MODE --}}
            <img
                src="{{ asset('icons/timesheet_blue.svg') }}"
                class="block w-6 h-6 shrink-0 dark:hidden group-hover:hidden"
                alt="icon light"
            >
            <img
                src="{{ asset('icons/timesheet_white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:hidden group-hover:block"
                alt="icon light hover"
            >

            {{-- DARK MODE --}}
            <img
                src="{{ asset('icons/timesheet_white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:block group-hover:hidden"
                alt="icon dark hover"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                Periode
            </span>
        @endif
    </x-side-link>
    <x-side-link
        :href="route('risk.pilih-periode')"
        :active="request()->routeIs('risk.pilih-periode')"
        class="group items-center h-14 px-6"
    >
        @if(request()->routeIs('risk.pilih-periode'))
            {{-- ACTIVE ICON (GLOBAL) --}}
            <img
                src="{{ asset('icons/checklist-white.svg') }}"
                class="block w-6 h-6 shrink-0"
                alt="icon active"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                Risk Register
            </span>
        @else
            {{-- LIGHT MODE --}}
            <img
                src="{{ asset('icons/checklist-blue.svg') }}"
                class="block w-6 h-6 shrink-0 dark:hidden group-hover:hidden"
                alt="icon light"
            >
            <img
                src="{{ asset('icons/checklist-white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:hidden group-hover:block"
                alt="icon light hover"
            >

            {{-- DARK MODE --}}
            <img
                src="{{ asset('icons/checklist-white.svg') }}"
                class=" hidden w-6 h-6 shrink-0 dark:block group-hover:hidden"
                alt="icon dark"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                Risk Register
            </span>
        @endif
    </x-side-link>

</div>
@endif
@if(auth()->user()->usertype === 'user')
<div x-data="{ open: false }"
    :class="sidebarOpen ? 'w-64' : 'w-0 md:w-20'"
    class="hidden md:block fixed inset-y-0 left-0 z-40 bg-white dark:bg-gray-800 transition-all duration-300">
    {{-- TOGGLE SIDEBAR --}}
    <button @click="sidebarOpen = !sidebarOpen"
        class="w-full h-16 flex items-center px-6
            hover:bg-gray-100 dark:hover:bg-gray-700
            group">
        {{-- LIGHT MODE --}}
        <img
            src="{{ asset('icons/xbox-menu-blue.svg') }}"
            class="block w-6 h-6 shrink-0 dark:hidden group-hover:hidden"
            alt="menu light"
        >
        <img
            src="{{ asset('icons/xbox-menu-white.svg') }}"
            class="hidden w-6 h-6 shrink-0 dark:hidden group-hover:block"
            alt="menu light hover"
        >

        {{-- DARK MODE --}}
        <img
            src="{{ asset('icons/xbox-menu-white.svg') }}"
            class="hidden w-6 h-6 shrink-0 dark:block group-hover:hidden"
            alt="menu dark"
        >

        <span
            x-show="sidebarOpen"
            x-transition
            class="ml-4 font-medium text-gray-700 dark:text-gray-200"
        >
            Menu
        </span>
    </button>
    <x-side-link
        :href="route('user.dashboard')"
        :active="request()->routeIs('user.dashboard')"
        class="group items-center h-14 px-6"
    >
        @if(request()->routeIs('user.dashboard'))
            {{-- ACTIVE ICON (GLOBAL) --}}
            <img
                src="{{ asset('icons/home_white.svg') }}"
                class="block w-6 h-6 shrink-0"
                alt="icon active"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200"
            >
                Dashboard
            </span>
        @else
            {{-- LIGHT MODE --}}
            <img
                src="{{ asset('icons/home_blue.svg') }}"
                class="block w-6 h-6 shrink-0 dark:hidden group-hover:hidden"
                alt="icon light"
            >
            <img
                src="{{ asset('icons/home_white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:hidden group-hover:block"
                alt="icon light hover"
            >

            {{-- DARK MODE --}}
            <img
                src="{{ asset('icons/home_white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:block group-hover:hidden"
                alt="icon dark"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200"
            >
                Dashboard
            </span>
        @endif
    </x-side-link>
    <x-side-link
        :href="route('user.pilih-periode')"
        :active="request()->routeIs('user.pilih-periode')"
        class="group items-center h-14 px-6"
    >
        @if(request()->routeIs('user.pilih-periode'))
            {{-- ACTIVE ICON (GLOBAL) --}}
            <img
                src="{{ asset('icons/checklist-white.svg') }}"
                class="block w-6 h-6 shrink-0"
                alt="icon active"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                Risk Register
            </span>
        @else
            {{-- LIGHT MODE --}}
            <img
                src="{{ asset('icons/checklist-blue.svg') }}"
                class="block w-6 h-6 shrink-0 dark:hidden group-hover:hidden"
                alt="icon light"
            >
            <img
                src="{{ asset('icons/checklist-white.svg') }}"
                class="hidden w-6 h-6 shrink-0 dark:hidden group-hover:block"
                alt="icon light hover"
            >

            {{-- DARK MODE --}}
            <img
                src="{{ asset('icons/checklist-white.svg') }}"
                class=" hidden w-6 h-6 shrink-0 dark:block group-hover:hidden"
                alt="icon dark"
            >
            <span
                x-show="sidebarOpen"
                x-transition
                class="ml-4 whitespace-nowrap text-gray-700 dark:text-gray-200">
                Risk Register
            </span>
        @endif
    </x-side-link>
</div>
@endif