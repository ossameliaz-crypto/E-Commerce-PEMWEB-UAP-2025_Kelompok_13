<nav x-data="{ open: false }" class="bg-white border-b border-orange-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <span class="text-3xl group-hover:animate-bounce transition">🧸</span>
                        <div>
                            <h1 class="font-extrabold text-orange-600 text-lg tracking-tight leading-none">Build-A-Teddy</h1>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dashboard</span>
                        </div>
                    </a>
                </div>

                {{-- ======================================================= --}}
                {{-- NAVIGATION DESKTOP (sm:flex) --}}
                {{-- ======================================================= --}}
                <div class="hidden space-x-8 sm:-my-px sm:ml-24 sm:flex">
                    
                    {{-- 1. Dashboard --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-600 hover:text-orange-600 font-bold border-b-2 border-transparent hover:border-orange-500 transition">
                        🏠 {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- 2. Workshop --}}
                    @if (Route::has('workshop'))
                        <x-nav-link :href="route('workshop')" :active="request()->routeIs('workshop')" class="text-gray-600 hover:text-orange-600 font-bold border-b-2 border-transparent hover:border-orange-500 transition">
                            🎨 Workshop
                        </x-nav-link>
                    @endif

                    {{-- 3. Katalog (FIXED: Menggunakan route('collection') jika sudah terdaftar) --}}
                    @if (Route::has('collection'))
                        <x-nav-link :href="route('collection')" :active="request()->routeIs('collection')" class="text-gray-600 hover:text-orange-600 font-bold border-b-2 border-transparent hover:border-orange-500 transition">
                            🎁 Katalog
                        </x-nav-link>
                    @endif

                    {{-- Link Khusus Role --}}
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-red-600 hover:text-red-800 font-bold">
                            🛡️ Admin Panel
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'seller')
                        <x-nav-link :href="route('seller.dashboard')" :active="request()->routeIs('seller.dashboard')" class="text-gray-600 hover:text-orange-600 font-bold">
                            🏪 Toko Saya
                        </x-nav-link>
                        <x-nav-link :href="route('seller.orders')" :active="request()->routeIs('seller.orders')" class="text-gray-600 hover:text-orange-600 font-bold">
                            📦 Pesanan
                        </x-nav-link>
                    @endif

                    {{-- 4. Lemari Saya (FIXED KRUSIAL: Menggunakan route('cart.index') ) --}}
                    @if (Route::has('cart.index'))
                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="text-gray-600 hover:text-orange-600 font-bold">
                            🧥 Lemari Saya
                        </x-nav-link>
                    @endif
                </div>
            </div>
            
            {{-- Bagian Dropdown User Profile (Tidak ada perubahan signifikan) --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        {{-- 🌟 INTEGRASI AVATAR/INISIAL DI NAVBAR 🌟 --}}
                        @php
                            $user = Auth::user();
                            $name = $user->name ?? 'User';
                            $initial = strtoupper(substr($name, 0, 1)); 
                            $imageUrl = $user->profile_picture ?? null; 
                            
                            $colorClasses = ['bg-red-500', 'bg-green-500', 'bg-blue-500', 'bg-yellow-500', 'bg-indigo-500', 'bg-pink-500', 'bg-purple-500'];
                            $colorKey = ord($initial) % count($colorClasses);
                            $color = $colorClasses[$colorKey];
                        @endphp
                        
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-md text-gray-800 bg-white hover:text-orange-600 focus:outline-none transition ease-in-out duration-150">
                            
                            {{-- TAMPILKAN FOTO atau INISIAL --}}
                            @if ($imageUrl)
                                {{-- Menggunakan asset() untuk path gambar --}}
                                <img src="{{ asset($imageUrl) }}" alt="{{ $name }}" class="h-8 w-8 rounded-full object-cover border me-2"> 
                            @else
                                <span class="h-8 w-8 rounded-full flex items-center justify-center text-sm font-semibold text-white {{ $color }} me-2">
                                    {{ $initial }}
                                </span>
                            @endif
                            
                            <div>{{ Auth::user()->name }}</div> 
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
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        @if(Auth::user()->role === 'member')
                            <x-dropdown-link :href="route('store.register')" class="text-orange-600 font-bold border-t border-gray-100">
                                🏪 Buka Toko Gratis
                            </x-dropdown-link>
                        @endif

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

            {{-- ======================================================= --}}
            {{-- NAVIGATION MOBILE (sm:hidden) --}}
            {{-- ======================================================= --}}
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

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            {{-- Dashboard --}}
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                🏠 {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- Workshop --}}
            @if (Route::has('workshop'))
                <x-responsive-nav-link :href="route('workshop')" :active="request()->routeIs('workshop')">
                    🎨 Workshop
                </x-responsive-nav-link>
            @endif

            {{-- Katalog --}}
            @if (Route::has('collection'))
                <x-responsive-nav-link :href="route('collection')" :active="request()->routeIs('collection')">
                    🎁 Katalog
                </x-responsive-nav-link>
            @endif
            
            {{-- Lemari Saya (FIXED KRUSIAL) --}}
            @if (Route::has('cart.index'))
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    🧥 Lemari Saya
                </x-responsive-nav-link>
            @endif
            
            {{-- Link Khusus Role --}}
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" class="text-red-600 font-bold">
                    🛡️ Admin Panel
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'seller')
                <x-responsive-nav-link :href="route('seller.dashboard')" class="text-green-600 font-bold">
                    🏪 Toko Saya
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.orders')" class="text-green-600 font-bold">
                    📦 Pesanan
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            {{-- ... Bagian Profil Mobile/Responsive ... --}}
            <div class="px-4">
                {{-- 🌟 INISIAL DI TAMPILAN MOBILE 🌟 --}}
                <div class="flex items-center mb-2">
                    @if ($imageUrl)
                        {{-- Menggunakan asset() untuk path gambar --}}
                        <img src="{{ asset($imageUrl) }}" alt="{{ $name }}" class="h-10 w-10 rounded-full object-cover border mr-2">
                    @else
                        <span class="h-10 w-10 rounded-full flex items-center justify-center text-lg font-bold text-white {{ $color }} mr-2">
                            {{ $initial }}
                        </span>
                    @endif
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                {{-- END INISIAL --}}
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if(Auth::user()->role === 'member')
                    <x-responsive-nav-link :href="route('store.register')" class="text-orange-600 font-bold">
                        🏪 Buka Toko
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