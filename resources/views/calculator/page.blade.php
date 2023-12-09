<!DOCTYPE html>
<html class="bg-gray-100 h-screen" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('Cyprus Electricity Calculator') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-blue-700 w-full">
            <div class="max-w-6xl m-auto p-5">
                <h1 class="text-4xl font-bold text-white w-full text-center p-8">{{ __('Cyprus Electricity Calculator') }}</h1>
                <div class="text-white text-xl w-full">
                    {{ __('The calculator uses the latest tariffs from the Electricity Authority of Cyprus to calculate the cost of your electricity consumption.') }}
                </div>
                <div class="text-sm text-white w-full pt-4 pb-2">
                    <p>{{ __('This site is not affiliated with the Electricity Authority of Cyprus.') }}</p>
                </div>
                <div class="text-sm w-full text-white flex justify-between items-center">
                    <p class="align-self-center"> <a href="{{__('https://www.eac.com.cy/EN/Pages/default.aspx') }}" target="_blank">{{ __('Click here to go to the EAC website.') }}</a></p>
                        <img height="65" width="78" src="{{asset('/images/calculator.png')}}" alt="Calculator">
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 w-full">
            <div class="max-w-6xl m-auto">
                @isset($cost)
                    @include('calculator.calculator', ['cost' => $cost])
                    @include('calculator.cost', ['cost' => $cost])
                @else
                    @include('calculator.calculator')
                @endisset
            </div>
        </div>
    </body>
</html>
