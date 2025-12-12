<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    {{-- 🚨 PERHATIAN: Modal ini akan memiliki latar belakang gelap secara default di Breeze/Jetstream --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            {{-- 🚨 PERBAIKAN: Ganti text-gray-900 menjadi text-white (Putih) --}}
            <h2 class="text-lg font-medium text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            {{-- 🚨 PERBAIKAN: Ganti text-gray-600 menjadi text-gray-200 (Abu-abu Terang) --}}
            <p class="mt-1 text-sm text-gray-200">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                {{-- 🚨 PERBAIKAN LABEL: Ganti text-black menjadi text-white (Putih) --}}
                <x-input-label for="password" value="{{ __('Password') }}" class="text-white" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    {{-- 🚨 PERBAIKAN INPUT: Hapus class Dark Mode default di text-input, tapi pastikan di sini inputnya Putih/Terang --}}
                    {{-- Ganti ke style yang sudah kita sepakati (Terang, Fokus Orange) --}}
                    class="mt-1 block w-full px-5 py-3 bg-gray-50 border border-gray-400 rounded-xl text-gray-900 focus:ring-2 focus:ring-orange-500 outline-none" 
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                {{-- Tombol Cancel biasanya secondary-button, jika warnanya gelap (seperti di screenshot Anda), itu sudah benar --}}
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>