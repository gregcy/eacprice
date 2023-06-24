<x-app-layout>
    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('adjustments.store') }}">
            @csrf
            <label for="start-date">{{ __('Start Date') }}</label>
            <input type="date"
                name="start-date"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="end-date">{{ __('End Date') }}</label>
            <input type="date"
                name="end-date"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="consumer-type">{{ __('Consumer Type') }}</label>
            <select name="consumer-type"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
                <option value="monthly">{{ __('Monthly') }}</option>
                <option value="bi-monthly">{{ __('Bi-Monthly') }}</option>
            </select>
            <label for="weighted-average-fuel-price">{{ __('Weighted Average Fuel Price  (€)') }}</label>
            <input type="number"
                name="weighted-average-fuel-price"
                step="0.01"
                min="0"
                placeholder="0.00"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <label for="Fuel Adjustment Coefficient">{{ __('Fuel Adjustment Coefficient') }}</label>
            <input type="number"
                name="Fuel Adjustment Coefficient"
                step = "0.00000001"
                min="0"
                placeholder="0.00000000"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <label for="voltage-type">{{ __('Voltage Type') }}</label>
            <select name="voltage-type"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
                <option value="low">{{ __('Low') }}</option>
                <option value="medium">{{ __('Medium') }}</option>
                <option value="high">{{ __('High') }}</option>
            </select>
            <fieldset class="inline-block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                <legend>{{ __('Fuel Adjustment') }}</legend>
                <div class="flex w-full pb-3">
                    <label for="total" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('Total:') }}</label>
                    <input type="number"
                        name="total"
                        step="0.00000001"
                        min="0"
                        placeholder="0.00000000"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-3">
                    <label for="fuel" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('Fuel:') }}</label>
                    <input type="number"
                        name="fuel"
                        step="0.00000001"
                        min="0"
                        placeholder="0.00000000"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-3">
                    <label for="co2-emissions" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('CO2 Emissions:') }}</label>
                    <input type="number"
                        name="co2-emissions"
                        step="0.00000001"
                        min="0"
                        placeholder="0.00000000"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-3">
                    <label for="cosmos" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('COSMOS:') }}</label>
                    <input type="number"
                        name="cosmos"
                        step="0.00000001"
                        min="0"
                        placeholder="0.00000000"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
            </fieldset>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
