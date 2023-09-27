<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-blue-700 w-full">
            <div class="max-w-6xl m-auto">
                <h1 class="text-4xl font-bold text-white w-full text-center  p-8">Cyprus Electricity Calculator</h1>
                <div class="text-white text-xl w-full">
                    The calculator uses the latest tariffs from the Electricity Authority of Cyprus to calculate the cost
                    of your electricity consumption.
                </div>
                <div class="text-sm text-white w-full py-6">
                    <p>This site is not affiliated with the Electricity Authority of Cyprus.</p>
                </div>
                <div class="text-sm w-full text-white pb-6 inline-grid">
                    <p class="justify-self-start inline-flex">Click on the logo to go to the EAC website.</p>
                    <a class="justify-self-end inline-flex" href="https://www.eac.com.cy/" target="_blank">
                        <img src="{{asset('/images/eac-logo.jpg')}}" alt="EAC Logo" class="w-16 h-16" />
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 w-full">
            <div class="max-w-6xl m-auto py-6">
                <form id="eac-calculator">
                    @csrf
                    <fieldset id="tariff" class="py-4">
                        <label for="tariff" class="text-lg font-medum pr-4">{{ __('Tariff:') }}</label>
                        <select name="tariff"
                            class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >
                            <option value="01" selected>{{__('01 - Single Rate Domestic Use') }}</option>
                            <option value="02">{{ __('02 - Two Rate Domestic Use') }}</option>
                            <option value="08">{{ __('08 - Special Tariff for Specific Categories of Vulnerable Customers') }}</option>
                        </select>
                    </fieldset>
                    <fieldset id="tariff01">
                        <div class="w-100">
                            <label for="consumption" class="text-lg font-medum pr-4">{{ __('Consumption (kWh):') }}</label>
                            <input type="number" name="consumption" step="1" min="0" placeholder="0" value="0" />
                        </div>
                        <div class="w-100 py-4">
                            <label for="credit_amount" class="text-lg font-medum pr-4">{{ __('Energy Returned Credits:') }}</label>
                            <input type="number" name="credit_amount" step="1" min="0" placeholder="0" value="0" />
                        </div>

                    </fieldset>
                    <fieldset id="tariff02">
                        <label for="consumption_standard">{{ __('Consumption During Standard Period 09:00-23:00 (kWh)') }}</label>
                        <input type="number" name="consumption_standard" step="1" min="0" placeholder="0" value="0" />
                        <label for="consumption_economy">{{ __('Consumption During Economy Period 23:00-09:00 (kWh)') }}</label>
                        <input type="number" name="consumption_economy" step="1" min="0" placeholder="0" value="0" />
                    </fieldset>
                    <fieldset id="tariff08">
                        <label for="consumption_total">{{ __('Consumption During Standard Period 09:00-23:00 (kWh)') }}</label>
                        <input type="number" name="consumption_total" step="1" min="0" placeholder="0" value="0" />
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>
