<x-app-layout>
    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tariffs.update', $tariff) }}">
            @csrf
            @method('patch')
            <label for="start_date">{{ __('Start Date') }}</label>
            <input type="date"
                value = "{{ old('start_date', $tariff->start_date) }}"
                name="start_date"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="end_date">{{ __('End Date') }}</label>
            <input type="date"
                value = "{{ old('end_date',$tariff->end_date) }}"
                name="end_date"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="code">{{ __('Tariff Code') }}</label>
            <input type="text"
                name="code"
                placeholder="Code"
                value = "{{ old('code',$tariff->code) }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <label for="recurring_supply_charge">{{ __('Supply Charge (€)') }}</label>
            <input type="number"
                name="recurring_supply_charge"
                step = "0.01"
                min="0"
                placeholder="0.00"
                value="{{ old('recurring_supply_charge', $tariff->recurring_supply_charge) }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <label for="recurring_meter_reading">{{ __('Meter Reading Charge (€)') }}</label>
            <input type="number"
                name="recurring_meter_reading"
                step = "0.01"
                min="0"
                placeholder="0.00"
                value="{{ old('recurring_meter_reading', $tariff->recurring_meter_reading ) }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <fieldset class="border-b mt-4 pb-2 mb-2 inline-block w-full border-gray-300">
                <legend class="text-base font-medium text-gray-900">{{ __('Tariffs 01 & 02') }}</legend>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="energy_charge_normal">{{ __('Energy Charge Normal (€/kWh)') }}</label>
                    <input type="number"
                        name="energy_charge_normal"
                        step = "0.0001"
                        min="0"
                        placeholder="0.0000"
                        value="{{ old('energy_charge_normal', $tariff->energy_charge_normal) }}"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="network_charge_normal">{{ __('Network Charge Normal (€/kWh)') }}</label>
                    <input type="number"
                        name="network_charge_normal"
                        step = "0.0001"
                        min="0"
                        placeholder="0.0000"
                        value="{{ old('network_charge_normal', $tariff->network_charge_normal) }}"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="ancillary_services_normal">{{ __('ancillary Services Normal (€/kWh)') }}</label>
                    <input type="number"
                        name="ancillary_services_normal"
                        step = "0.0001"
                        min="0"
                        placeholder="0.0000"
                        value="{{ old('ancillary_services_normal', $tariff->ancillary_services_normal) }}"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
            </fieldset>
            <fieldset class="border-b pb-2 mb-2 inline-block w-full border-gray-300">
                <legend class="text-base font-medium text-gray-900">{{ __('Tariff 02') }}</legend>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="ancillary_services_normal" for="energy_charge_reduced">{{ __('Energy Charge Reduced (€/kWh)') }}</label>
                    <input type="number"
                        name="energy_charge_reduced"
                        step = "0.0001"
                        min="0"
                        placeholder="0.0000"
                        value="{{ old('energy_charge_reduced', $tariff->energy_charge_reduced) }}"
                        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="network_charge_reduced">{{ __('Network Charge Reduced (€/kWh)') }}</label>
                    <input type="number"
                        name="network_charge_reduced"
                        step = "0.0001"
                        min="0"
                        placeholder="0.0000"
                        value="{{ old('network_charge_reduced',$tariff->network_charge_reduced) }}"
                        class="block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="ancillary_services_reduced">{{ __('ancillary Services Reduced (€/kWh)') }}</label>
                    <input type="number"
                        name="ancillary_services_reduced"
                        step = "0.0001"
                        min="0"
                        placeholder="0.0000"
                        value="{{ old('ancillary_services_reduced', $tariff->ancillary_services_reduced) }}"
                        class="block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
            </fieldset>
            <fieldset class="pb-2 mb-2 inline-block w-full border-gray-300">
                <legend class="text-base font-medium text-gray-900">{{ __('Tariff 08') }}</legend>
                <div class="flex w-full pb-1">
                <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="energy_charge_subsidy_first">{{ __('Energy Charge 1st Bracket (€/kWh)') }}</label>
                    <input type="number"
                        name="energy_charge_subsidy_first"
                        step = "0.0001"
                        min="0"
                        placeholder="0.0000"
                        value="{{ old('energy_charge_subsidy_first', $tariff->energy_charge_subsidy_first) }}"
                        class="block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="energy_charge_subsidy_second">{{ __('Energy Charge 2nd Bracket (€/kWh)') }}</label>
                    <input type="number"
                        name="energy_charge_subsidy_second"
                        step = "0.0001"
                        min="0"
                        placeholder="0.0000"
                        value="{{ old('energy_charge_subsidy_second', $tariff->energy_charge_subsidy_second) }}"
                        class="block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="energy_charge_subsidy_third">{{ __('Energy Charge 3rd Bracket (€/kWh)') }}</label>
                    <input type="number"
                        name="energy_charge_subsidy_third"
                        step = "0.0001"
                        min="0"
                        placeholder="0.0000"
                        value="{{ old('energy_charge_subsidy_third', $tariff->energy_charge_subsidy_third) }}"
                        class="block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="energy_charge_subsidy_first">{{ __('Supply Charge 1st Bracket (€)') }}</label>
                    <input type="number"
                        name="supply_subsidy_first"
                        step = "0.01"
                            min="0"
                        placeholder="0.00"
                        value="{{ old('supply_subsidy_first', $tariff->supply_subsidy_first) }}"
                        class="block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="energy_charge_subsidy_second">{{ __('Supply Charge 2nd Bracket (€)') }}</label>
                    <input type="number"
                        name="supply_subsidy_second"
                        step = "0.01"
                        min="0"
                        placeholder="0.00"
                        value="{{ old('supply_subsidy_second', $tariff->supply_subsidy_second) }}"
                        class="block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
                <div class="flex w-full pb-1">
                    <label class="inline w-72 align-middle pt-2.5 pr-2.5" for="energy_charge_subsidy_third">{{ __('Supply Charge 3rd Bracket (€)') }}</label>
                    <input type="number"
                        name="supply_subsidy_third"
                        step = "0.01"
                        min="0"
                        placeholder="0.00"
                        value="{{ old('supply_subsidy_third', $tariff->supply_subsidy_third) }}"
                        class="block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                </div>
            </fieldset>
            <div class="flex w-full pb-1 pt-4">
                <label for="source" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('Source:') }}</label>
                <input type="text"
                    name="source"
                    value="{{ old('source', $tariff->source) }}"
                    class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    />
            </div>
            <div class="flex w-full pb-1 pt-4">
                <label for="source_name" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('Source Name:') }}</label>
                <input type="text"
                    name="source_name"
                    value="{{ old('source_name', $tariff->source_name) }}"
                    class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    />
            </div>
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
