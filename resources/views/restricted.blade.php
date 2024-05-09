<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <title>{{ env('APP_NAME') }}</title>
     <link rel="icon" type="image/x-icon" href="{{ asset('image/SLSPI-LOGO.png') }}">

     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

     <!-- Scripts -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased  bg-no-repeat bg-cover" style="background-image: url('{{ asset('storage/images/bg-school.jpg') }}')">
     <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen selection:bg-blue-500 selection:text-white gap-5 bg-red-600 bg-opacity-75">
          {{-- @if (Route::has('login'))
               <livewire:welcome.navigation />
          @endif --}}
          {{-- <x-application-logo class="w-72 "/> --}}
          <div class="text-center text-white">
               <h1 class="text-7xl font-extrabold">Restricted Account</h1>
               <h1 class="text-2xl mt-10">This Account:</h1>
               <div class="inline-flex gap-4 mt-4 bg-white text-gray-800 py-2 px-4 rounded-lg">
                    <img src="{{ asset(auth()->user()->profile->url) }}" class="rounded-full max-h-20 shadow">
                    <div class="text-left my-auto">
                         <h2 class="text-2xl font-bold">{{ auth()->user()->name }}</h2>
                         <h3 class="text-lg">{{ auth()->user()->email }}</h3>
                    </div>
               </div>
               <div>
                    <p class="mt-5 text-lg">Is restricted, please come back again to see if you are unrestricted again.</p>
               </div>

               @livewire('logout-button')
               {{-- <a href="{{ route('examinees.create') }}" wire:navigate class="transition ease-in-out duration-300 px-6 py-2 mt-5 bg-blue-600 hover:bg-blue-900 text-white font-bold rounded">Get Started</a> --}}
          </div>
     </div>
</body>
</html>
