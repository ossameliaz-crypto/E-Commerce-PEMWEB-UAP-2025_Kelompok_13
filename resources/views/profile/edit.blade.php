{{-- File: resources/views/profile/edit.blade.php (Pastikan struktur ini) --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Form 1: Profile Information (Dibungkus card putih) --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Form 2: Update Image --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('profile.partials.profile-update-image') 
            </div>

            {{-- Form 3: Update Password --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Form 4: Delete Account --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>