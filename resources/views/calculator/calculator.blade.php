<form id="eac-calculator" class="mb-12" method="POST" action="{{ route('calculator.calculate') }}">
    @csrf
    <fieldset id="tariff" class="py-4">
        <label for="tariff-select" class="text-lg font-medum pr-4">{{ __('Tariff:') }}</label>
        <select id="tariff-select" name="tariff"
            class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            @php
                $options = [
                    '01' => __('01 - Single Rate Domestic Use'),
                    '02' => __('02 - Two Rate Domestic Use'),
                    '08' => __('08 - Special Tariff for Vulnerable Customers'),
                ];
                $selectedValue = old('tariff', $values['tariff'] ?? '01');
            @endphp

            @foreach($options as $value => $label)
                <option value="{{ $value }}" @if($selectedValue == $value) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
    </fieldset>
    <fieldset id="tariff01" class="{{ (isset($values) && in_array($values['tariff'], ['01', '08'])) || !isset($values) ? 'block' : 'hidden' }}">
        <div class="w-100">
            <label for="consumption" class="text-lg font-medium pr-20">{{ __('Consumption (kWh):') }}</label>
            <input id="consumption" type="number" name="consumption" step="1" min="0" placeholder="0" value="{{ old('consumption', $values['consumption'] ?? 0) }}">
        </div>
        <div class="w-100 py-4">
            <label for="credit-amount" class="text-lg font-medium pr-4">{{ __('Returned Solar Power (kWh):') }}</label>
            <input id="credit-amount" type="number" name="credit-amount" step="1" min="0" placeholder="0" value="{{ old('credit-amount', $values['credit-amount'] ?? 0) }}">
        </div>
    </fieldset>

    <fieldset id="tariff02" class="{{ (isset($values) && $values['tariff'] === '02') ? 'block' : 'hidden' }}">
        <div class="w-100">
            <label for="consumption-standard" class="text-lg font-medium pr-5">{{ __('Consumption During Standard Period 09:00-23:00 (kWh):') }}</label>
            <input id="consumption-standard" type="number" name="consumption-standard" step="1" min="0" placeholder="0" value="{{ old('consumption-standard', $values['consumption-standard'] ?? 0) }}">
        </div>
        <div class="w-100 py-4">
            <label for="consumption-economy" class="text-lg font-medium pr-4">{{ __('Consumption During Economy Period 23:00-09:00 (kWh):') }}</label>
            <input id="consumption-economy" type="number" name="consumption-economy" step="1" min="0" placeholder="0" value="{{ old('consumption-economy', $values['consumption-economy'] ?? 0) }}">
        </div>
    </fieldset>

    <x-primary-button class="mt-4">{{ __('Calculate') }}</x-primary-button>
</form>
<script>
    const selectElement = document.getElementById('tariff-select');
    const tariff01 = document.getElementById('tariff01');
    const tariff02 = document.getElementById('tariff02');
    const inputs = document.getElementsByTagName('input');
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
        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].type === 'number') {
                inputs[i].value = '';
            }
        }
    });
</script>
