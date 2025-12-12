<!DOCTYPE html>
{{-- 🚀 PERBAIKAN 1: Pastikan tag html tidak memiliki class="dark" --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    {{-- 🚀 PERBAIKAN 2: Pastikan body tidak punya class gelap --}}
    <body class="font-sans antialiased bg-white"> 
        
        {{-- Mengganti min-h-screen bg-white dengan div kosong karena body sudah bg-white --}}
        <div class="min-h-screen"> 
            @include('layouts.navigation')

            @isset($header)
                {{-- PERBAIKAN 3: Header menggunakan bg-white --}}
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>