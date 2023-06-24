<x-app-layout>
    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('adjustments.store') }}">
            @csrf
            <label for="start_date">{{ __('Start Date') }}</label>
            <input type="date"
                name="Start Date"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="end_date">{{ __('End Date') }}</label>
            <input type="date"
                name="End Date"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="consumer_type">{{ __('Consumer Type') }}</label>
            <select name="consumer_type"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
                <option value="monthly">{{ __('Monthly') }}</option>
                <option value="bi-monthly">{{ __('Bi-Monthly') }}</option>
            </select>
            <label for="Weighted Average Fuel Price">{{ __('Weighted Average Fuel Price  (€)') }}</label>
            <input type="number"
                name="Weighted Average Fuel Price"
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
            <label for="voltage_type">{{ __('Voltage Type') }}</label>
            <select name="voltage_type"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
                <option value="low">{{ __('Low') }}</option>
                <option value="medium">{{ __('Medium') }}</option>
                <option value="high">{{ __('High') }}</option>
            </select>
            <fieldset>
                <legend>{{ __('Fuel Adjustment') }}</legend>
                <input type="number"
                    name="Fuel Adjustment"
                    step="0.00000001"
                    min="0"
                    placeholder="Total"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >
            </fieldset>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
