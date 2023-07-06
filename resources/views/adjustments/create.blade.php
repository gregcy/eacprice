<x-app-layout>
    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('adjustments.store') }}">
            @csrf
            <label for="start_date">{{ __('Start Date') }}</label>
            <input type="date"
                name="start_date"
                value = "{{ old('start_date') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="end_date">{{ __('End Date') }}</label>
            <input type="date"
                name="end_date"
                value = "{{ old('end_date') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="consumer_type">{{ __('Consumer Type') }}</label>
            <select name="consumer_type"class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <option value="Monthly" {{ old('consumer_type') == __('Monthly') ? 'selected' : '' }}>{{ __('Monthly') }}</option>
                <option value="Bi-Monthly" {{ old('consumer_type') == __('Bi-Monthly') ? 'selected' : '' }}>{{ __('Bi-Monthly') }}</option>
            </select>
            <label for="weighted_average_fuel_price">{{ __('Weighted Average Fuel Price  (€)') }}</label>
            <input type="number"
                name="weighted_average_fuel_price"
                step="0.01"
                min="0"
                placeholder="0.00"
                value = "{{ old('weighted_average_fuel_price') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <label for="fuel_adjustment_coefficient">{{ __('Fuel Adjustment Coefficient') }}</label>
            <input type="number"
                name="fuel_adjustment_coefficient"
                step = "0.00000001"
                min="0"
                placeholder="0.00000000"
                value = "{{ old('fuel_adjustment_coefficient') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <label for="voltage_type">{{ __('Voltage Type') }}</label>
            <select name="voltage_type"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <option value="Low" {{ old('voltage_type') == __('Low') ? 'selected' : '' }}>{{ __('Low') }}</option>
                <option value="Medium" {{ old('voltage_type') == __('Medium') ? 'selected' : '' }}>{{ __('Medium') }}</option>
                <option value="High" {{ old('voltage_type') == __('High') ? 'selected' : '' }}>{{ __('High') }}</option>
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
                        value="{{ old('total') }}"
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
                        value="{{ old('fuel') }}"
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
                        value="{{ old('co2_emissions') }}"
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
                        value="{{ old('cosmos') }}"
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
    </div>
</x-app-layout>
