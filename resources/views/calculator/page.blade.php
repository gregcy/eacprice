@php
    $currentLocale = app()->getLocale();
@endphp

<!DOCTYPE html>
<html class="bg-gray-100 h-screen flex flex-col" lang="{{ str_replace('_', '-', $currentLocale ) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Estimate your electricity cost in Cyprus with our user-friendly calculator. Easily calculate energy expenses, optimize usage, and make informed decisions about your utility consumption. Take control of your electricity bills today.">

        <title>{{ __('Cyprus Electricity Calculator') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "TechArticle",
                "headline": "Electricity Cost Calculator in Cyprus",
                "description": "Calculate your electricity cost in Cyprus with our user-friendly online calculator. Optimize energy usage and make informed decisions to manage your utility expenses.",
                "datePublished": "2023-12-26T12:00:00+02:00",
                "author": {
                    "@type": "Person",
                    "name": "Greg Andreou",
                    "url": "https://greg.cy/"
                },
                "image": "https://eac.greg.cy/images/calculator.png",
                "publisher": {
                    "@type": "Person",
                    "name": "Greg Andreou",
                    "logo": {
                    "@type": "ImageObject",
                    "url": "https://eac.greg.cy/images/calculator.png"
                    }
                },
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": "https://eac.greg.cy/"
                }
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-screen w-full flex flex-col">
        <div class="bg-blue-700 w-full">
            <div class="max-w-6xl m-auto p-5">
                <div class="w-full justify-between flex">
                    @if ($currentLocale == 'el')
                    <span class="ml-auto"><a href="/en/" class="text-white "><img class="h-5 ml-[5px]" src="/images/gb.png" width="40" height="20" alt="English flag">{{ __('English') }}</a></span>
                    <span class="ml-5 underline decoration-4 underline-offset-8 text-white font-black"><img class="h-5 ml-4" src="/images/gr.png" width="30" height="20" alt="Greek flag">{{ __('Greek') }}</span>
                    @else
                    <span class="ml-auto underline decoration-4 underline-offset-8 text-white font-black"><img class="h-5 ml-[5px]" src="/images/gb.png" width="40" height="20" alt="English flag">{{ __('English') }}</span>
                    <span class="ml-5"><a href="/el/" class="text-white"><img class="h-5 ml-1.5" src="/images/gr.png" width="30" height="20" alt="Greek flag">{{ __('Greek') }}</a></span>
                    @endif
                </div>
                <h1 class="text-4xl font-bold text-white w-full text-center p-8">{{ __('Cyprus Electricity Calculator') }}</h1>
                <div class="text-white text-xl w-full">
                    {{ __('The calculator uses the latest tariffs from the Electricity Authority of Cyprus to calculate the cost of your electricity consumption.') }}
                </div>
                <div class="text-sm text-white w-full pt-4 pb-2">
                    <p>{{ __('This site is not affiliated with the Electricity Authority of Cyprus.') }}</p>
                </div>
                <div class="text-sm w-full text-white flex justify-between items-center">
                    <p class="align-self-center"> <a href="{{__('https://www.eac.com.cy/EN/Pages/default.aspx') }}" target="_blank" class="underline">{{ __('Click here to go to the EAC website.') }}</a></p>
                    <img height="65" width="78" src="{{asset('/images/calculator.png')}}" alt="Calculator">
                </div>
            </div>
        </div>
        <div class="bg-gray-100 w-full">
            <div class="max-w-6xl m-auto">
                @isset($cost)
                    @include('calculator.calculator', ['cost' => $cost])
                @else
                    @include('calculator.calculator')
                @endisset
            </div>
        </div>
        @isset($cost)
        <div class="bg-white w-full">
            <div class="max-w-6xl m-auto">
                @include('calculator.cost', ['cost' => $cost])
            </div>
        </div>
        @endisset
        <footer class="max-w-6xl mx-auto mt-auto p-5 w-full">
            <div class="text-sm">{{ __('Source Code') }}: <a href="https://github.com/gregcy/eacprice" target="_blank" class="underline text-blue-700">https://github.com/gregcy/eacprice</a></div>
            <div class="text-sm">{{ __('License') }}: <a href="https://opensource.org/licenses/MIT" target="_blank" class="underline text-blue-700">{{ __('MIT') }}</a></div>
            <div class="text-sm">{{ __('Calculator Icon') }}: Boca Tutor, <a target="_blank" class="underline text-blue-700" href="https://commons.wikimedia.org/wiki/File:Calculator_icon.svg">Calculator icon</a>, <a target="_blank" class="underline text-blue-700" href="https://creativecommons.org/licenses/by-sa/3.0/legalcode" rel="license">CC BY-SA 3.0</a> </div>
        </footer>
    </body>
</html>
