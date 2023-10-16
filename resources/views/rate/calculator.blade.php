
<form id="eac-calculator" class="mb-12" method="POST" action="{{ route('rate.page') }}">
    @csrf
    <fieldset id="tariff" class="py-4">
        <label for="tariff-select" class="text-lg font-medum pr-4">{{ __('Tariff:') }}</label>
        <select id="tariff-select" name="tariff"
            class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
            <option value="01" selected>{{__('01 - Single Rate Domestic Use') }}</option>
            <option value="02">{{ __('02 - Two Rate Domestic Use') }}</option>
            <option value="08">{{ __('08 - Special Tariff for Vulnerable Customers') }}</option>
        </select>
    </fieldset>
    <fieldset id="tariff01" class="block">
        <div class="w-100">
            <label for="consumption" class="text-lg font-medum pr-20">{{ __('Consumption (kWh):') }}</label>
            <input id="consumption" type="number" name="consumption" step="1" min="0" placeholder="0" value="0">
        </div>
        <div class="w-100 py-4">
            <label for="credit-amount" class="text-lg font-medum pr-4">{{ __('Returned Solar Power (kWh):') }}</label>
            <input id="credit-amount" type="number" name="credit-amount" step="1" min="0" placeholder="0" value="{{ old('credit-amount', $cost->credit-amount }}">
        </div>

    </fieldset>
    <fieldset id="tariff02" class="hidden">
        <div class="w-100">
            <label for="consumption-standard" class="text-lg font-medum pr-5">{{ __('Consumption During Standard Period 09:00-23:00 (kWh):') }}</label>
            <input id="consumption-standard" type="number" name="consumption-standard" step="1" min="0" placeholder="0" value="0">
        </div>
        <div class="w-100 py-4">
            <label for="consumption-economy" class="text-lg font-medum pr-4">{{ __('Consumption During Economy Period 23:00-09:00 (kWh):') }}</label>
            <input id="consumption-economy" type="number" name="consumption-economy" step="1" min="0" placeholder="0" value="0">
        </div>
    </fieldset>
    <x-primary-button class="mt-4">{{ __('Calculate') }}</x-primary-button>
</form>
<script>
    const selectElement = document.getElementById('tariff-select');
    const tariff01 = document.getElementById('tariff01');
    const tariff02 = document.getElementById('tariff02');
    selectElement.addEventListener('change', function() {
        let selectedValue = selectElement.value;
        if (selectedValue == '01') {
            tariff01.classList.replace('hidden', 'block');
            tariff02.classList.replace('block', 'hidden');
        }
        else if (selectedValue == '02') {
            tariff01.classList.replace('block', 'hidden');
            tariff02.classList.replace('hidden', 'block');
        }
        else if (selectedValue == '08') {
            tariff01.classList.replace('hidden', 'block');
            tariff02.classList.replace('block','hidden');
        }
    });
</script>
