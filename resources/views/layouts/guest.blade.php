<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('storage/images/NDSCP.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-no-repeat bg-cover" style="background-image: url('{{ asset('storage/images/bg-school.jpg') }}')">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-red-600 bg-opacity-75" >
            <div class="flex gap-12">
                <div class="my-auto flex gap-5">
                    <div class="mx-auto">
                        <a href="/" wire:navigate>
                            <x-application-logo class="w-48 mx-auto aspect-square fill-current text-gray-500" />
                        </a>
                    </div>
                    <div class="my-auto drop-shadow-xl">
                        <h1 class="font-extrabold text-7xl text-white ">Notre Dame<br>of Kiamba, Inc.</h1>
                        <h1 class="font-extrabold text-7xl text-white"></h1>
                    </div>
                </div>
                <div class="my-auto max-h-screen py-10 px-5 overflow-auto no-scrollbar">
                    <div class="w-96 sm:max-w-md mt-6 px-6 py-4 bg-white shadow-lg sm:rounded-lg">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
