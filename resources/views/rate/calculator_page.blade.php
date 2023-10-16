<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-blue-700 w-full">
            <div class="max-w-6xl m-auto p-4">
                <h1 class="text-4xl font-bold text-white w-full text-center  p-8">Cyprus Electricity Calculator</h1>
                <div class="text-white text-xl w-full">
                    The calculator uses the latest tariffs from the Electricity Authority of Cyprus to calculate the cost
                    of your electricity consumption.
                </div>
                <div class="text-sm text-white w-full py-6">
                    <p>This site is not affiliated with the Electricity Authority of Cyprus.</p>
                </div>
                <div class="text-sm w-full text-white flex justify-between items-center">
                    <p class="align-self-center">Click on the logo to go to the EAC website.</p>
                    <a href="https://www.eac.com.cy/" target="_blank">
                        <img src="{{asset('/images/eac-logo.jpg')}}" alt="EAC Logo" class="w-16 h-16">
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 w-full">
            <div class="max-w-6xl m-auto p-4">
                @include('rate.calculator')
            </div>
        </div>
    </body>
</html>
