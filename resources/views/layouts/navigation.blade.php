<nav x-data="{ open: false }" class="bg-white border-b border-orange-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <span class="text-3xl group-hover:animate-bounce transition">🧸</span>
                        <div>
                            <h1 class="font-extrabold text-orange-600 text-lg tracking-tight leading-none">Build-A-Teddy</h1>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dashboard</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Menu Tengah) -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-600 hover:text-orange-600 font-bold border-b-2 border-transparent hover:border-orange-500 transition">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- LOGIKA MENU SESUAI ROLE (RBAC) -->
                    
                    <!-- 1. Menu Khusus Admin -->
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-red-600 hover:text-red-800 font-bold">
                            🛡️ Admin Panel
                        </x-nav-link>
                    @endif

                    <!-- 2. Menu Khusus Seller -->
                    @if(Auth::user()->role === 'seller')
                        <x-nav-link :href="route('seller.dashboard')" :active="request()->routeIs('seller.dashboard')" class="text-green-600 hover:text-green-800 font-bold">
                            🏪 Toko Saya
                        </x-nav-link>
                        <x-nav-link :href="route('seller.orders')" :active="request()->routeIs('seller.orders')" class="text-gray-600 hover:text-orange-600 font-bold">
                            📦 Pesanan
                        </x-nav-link>
                    @endif

                    <!-- 3. Menu Umum (Semua User) -->
                    <x-nav-link :href="route('wardrobe')" :active="request()->routeIs('wardrobe')" class="text-gray-600 hover:text-orange-600 font-bold">
                        🧥 Lemari Saya
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown (Kanan) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                
                <!-- Widget Saldo (Opsional) -->
                <div class="mr-4 px-4 py-1 bg-orange-50 rounded-full border border-orange-200 text-sm font-bold text-orange-700 hidden lg:block">
                    💰 Saldo: Rp {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-md text-gray-600 bg-white hover:text-orange-600 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div> <!-- Nama User -->
                            
                            <!-- Badge Role (Label Kecil) -->
                            <span class="ml-2 text-[10px] px-2 py-0.5 rounded-full text-white {{ Auth::user()->role === 'admin' ? 'bg-red-500' : (Auth::user()->role === 'seller' ? 'bg-green-500' : 'bg-blue-400') }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Profile -->
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Tombol Buka Toko (Hanya Muncul Jika Masih Member Biasa) -->
                        @if(Auth::user()->role === 'member')
                            <x-dropdown-link :href="route('store.register')" class="text-orange-600 font-bold border-t border-gray-100">
                                🏪 Buka Toko Gratis
                            </x-dropdown-link>
                        @endif

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-red-600 hover:bg-red-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Menu (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Tampilan HP) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" class="text-red-600 font-bold">
                    Admin Panel
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'seller')
                <x-responsive-nav-link :href="route('seller.dashboard')" class="text-green-600 font-bold">
                    Toko Saya
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if(Auth::user()->role === 'member')
                    <x-responsive-nav-link :href="route('store.register')" class="text-orange-600 font-bold">
                        Buka Toko
                    </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>