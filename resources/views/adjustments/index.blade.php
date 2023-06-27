<x-app-layout>
    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('adjustments.store') }}">
            @csrf
            <label for="start_date">{{ __('Start Date') }}</label>
            <input type="date"
                name="start_date"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="end_date">{{ __('End Date') }}</label>
            <input type="date"
                name="end_date"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="consumer_type">{{ __('Consumer Type') }}</label>
            <select name="consumer_type"class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <option value="Monthly">{{ __('Monthly') }}</option>
                <option value="Bi-Monthly">{{ __('Bi-Monthly') }}</option>
            </select>
            <label for="weighted_average_fuel_price">{{ __('Weighted Average Fuel Price  (€)') }}</label>
            <input type="number"
                name="weighted_average_fuel_price"
                step="0.01"
                min="0"
                placeholder="0.00"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <label for="fuel_adjustment_coefficient">{{ __('Fuel Adjustment Coefficient') }}</label>
            <input type="number"
                name="fuel_adjustment_coefficient"
                step = "0.00000001"
                min="0"
                placeholder="0.00000000"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <label for="voltage_type">{{ __('Voltage Type') }}</label>
            <select name="voltage_type"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <option value="Low">{{ __('Low') }}</option>
                <option value="Medium">{{ __('Medium') }}</option>
                <option value="High">{{ __('High') }}</option>
            </select>
            <fieldset class="inline-block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                <legend>{{ __('Fuel Adjustment') }}</legend>
                <div class="flex w-full pb-1">
                    <label for="total" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('Total:') }}</label>
                    <input type="number"
                        name="total"
                        step="0.00000001"
                        min="0"
                        placeholder="0.00000000"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        />
                </div>
                <div class="flex w-full pb-1">
                    <label for="fuel" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('Fuel:') }}</label>
                    <input type="number"
                        name="fuel"
                        step="0.00000001"
                        min="0"
                        placeholder="0.00000000"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        />
                </div>
                <div class="flex w-full pb-1">
                    <label for="co2_emissions" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('CO2 Emissions:') }}</label>
                    <input type="number"
                        name="co2_emissions"
                        step="0.00000001"
                        min="0"
                        placeholder="0.00000000"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        />
                </div>
                <div class="flex w-full pb-3">
                    <label for="cosmos" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('COSMOS:') }}</label>
                    <input type="number"
                        name="cosmos"
                        step="0.00000001"
                        min="0"
                        placeholder="0.00000000"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        />
                </div>
            </fieldset>
            @if ($errors->any())
                <div class="block p-2 text-red-800 bg-opacity-30 bg-red-300 w-full border-red-500 focus:border-red-700 focus:ring focus:ring-red-300 focus:ring-opacity-50 rounded-md shadow-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
        </form>
        <div class="mt-6 bg-transparent shadow-sm rounded-lg divide-y space-y-4">
            @foreach ($adjustments as $adjustment)
                <div class="p-6 bg-white flex space-y-2">
                    <div class="flex-1">
                        <div class="pb-2 flex justify-between items-center">
                            <div>
                                <span class="text-gray-800 font-bold text-lg"> {{__('Fuel Adjustment Coefficient') }}</span>
                            </div>
                            <div>
                                <svg class="inline w-[19px] h-[19px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                                </svg>
                                <span class="inline text-gray-800 font-bold text-lg">{{ date('d/m/Y', strtotime($adjustment->start_date)) }} - {{ date('d/m/Y', strtotime($adjustment->end_date)) }}</span>
                            </div>
                            @if ($adjustment->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('adjustments.edit', $adjustment)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <div class="flex justify-start items-center border-b pb-2 mb-2">
                            <div>
                                <span class="text-gray-500 text-sm"> {{__('Consumer Type:') }}</span>
                                <span class="inline text-gray-500 text-sm">{{ ucfirst(__($adjustment->consumer_type)) }}</span>
                            </div>
                            <div>
                                <span class="pl-3 text-gray-500 text-sm"> {{__('Voltage:') }}</span>
                                <span class="inline text-gray-500 text-sm">{{ ucfirst(__($adjustment->voltage_type)) }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-start">
                            <table>
                                <tr>
                                    <td class="text-grey-800 font-bold pb-1">{{ __('Fuel Adjustment Cost per kWh:') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-800"> {{__('Fuel Cost') }}</td>
                                    <td class="pl-4 inline text-gray-800">€{{ number_format($adjustment->fuel, 4) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-800"> {{__('CO2 Emissions Cost') }}</td>
                                    <td class="pl-4 inline text-gray-800">€{{ number_format($adjustment->co2_emissions, 4) }}</td>
                                </tr>
                                <tr class="border-b border-black">
                                    <td class="text-gray-800"> {{__('COSMOS Cost') }}</td>
                                    <td class="pl-4 inline text-gray-800">€{{ number_format($adjustment->cosmos, 4) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-800 font-bold"> {{__('Total') }}</td>
                                    <td class="pl-4 inline text-gray-800 font-bold">€{{ number_format($adjustment->total, 4) }}</td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td class="text-gray-800 font-bold"> {{__('Average Weighted Fuel Price:') }}</td>
                                    <td class="pl-4 inline text-gray-800 font-bold">€{{ number_format($adjustment->weighted_average_fuel_price, 2) }}</span>
                                </tr>
                                <tr>
                                    <td class="text-gray-800 font-bold"> {{__('Fuel Adjustment Coefficient:') }}</td>
                                    <td class="pl-4 inline text-gray-800 font-bold">{{ $adjustment->fuel_adjustment_coefficient }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
