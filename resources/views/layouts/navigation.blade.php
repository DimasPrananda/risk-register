<nav x-data="{ open: false }" 
    :class="sidebarOpen ? 'ml-40 md:ml-64' : 'ml-0 md:ml-20'"
    class=" fixed top-0 left-0 right-0 z-50 transition-all duration-300 dark:bg-gray-900/70
           backdrop-blur-md backdrop-saturate-150
           border-b border-white/40 dark:border-gray-900/40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link class="flex flex-col" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <h3>PT United Tractors Semen Gresik</h3>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-300">
                        {{ __('Manajemen Risiko & Inovasi') }}
                    </h2>
                </x-nav-link>
            </div>

            <div class=" flex w-full md:w-auto items-center justify-end">
                <!-- NOTIFICATION -->
                <div class="relative" x-data="{ openNotif: false }">
                    <button @click=" openNotif = !openNotif;"
                        class="relative p-2 rounded-full text-gray-600 dark:text-gray-400">

                        <!-- Bell Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 11-6 0h6z"/>
                        </svg>

                        <!-- BADGE -->
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="absolute top-0 right-0 bg-red-600 text-white dark:text-white
                                        text-xs rounded-full px-1">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- DROPDOWN -->
                    <div x-show="openNotif" @click.outside="openNotif=false"
                        class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800
                                rounded-lg shadow-lg z-50">

                        <div class="p-3 font-semibold border-b dark:text-white">
                            Notifikasi
                        </div>

                        @forelse(auth()->user()->unreadNotifications as $notif)

                            @php
                                $detailRoute = auth()->user()->usertype === 'admin'
                                    ? route('risk.detail', ['sasaran' => $notif->data['sasaran']])
                                    : route('user.detail', ['sasaran' => $notif->data['sasaran']]);
                            @endphp

                            <a
                                href="{{ $detailRoute }}"
                                @click.prevent="
                                    fetch('{{ route('notif.readSingle', $notif->id) }}')
                                        .then(() => {
                                            window.location.href = '{{ $detailRoute }}'
                                        })
                                "
                                class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                <p class="text-sm dark:text-white">{{ $notif->data['message'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $notif->created_at->diffForHumans() }}
                                </p>
                            </a>

                        @empty
                            <div class="p-4 text-sm text-gray-500">
                                Tidak ada notifikasi
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class=" inline-flex items-center px-3 py-2 text-sm leading-4 font-medium text-gray-500 dark:text-gray-400 bg-transparent dark:bg-transparent hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div class=" flex flex-col text-right mr-5">
                                    <div>{{ Auth::user()->usertype }}</div>
                                    <div class=" text-lg text-gray-800 dark:text-gray-300">{{ Auth::user()->name }}</div>
                                </div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.user')" :active="request()->routeIs('admin.user')">
                {{ __('User Management') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.departemen')" :active="request()->routeIs('admin.departemen')">
                {{ __('Departemen') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.taksonomi')" :active="request()->routeIs('admin.taksonomi')">
                {{ __('Taksonomi Risiko') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('risk.pilih-periode')" :active="request()->routeIs('risk.pilih-periode')">
                {{ __('Risk Register') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
