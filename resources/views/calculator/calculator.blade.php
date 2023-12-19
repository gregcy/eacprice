<form id="eac-calculator" class="p-5 mb-2" method="POST" action="{{ route('calculator.calculate',['lang' => app()->getLocale()]) }}">
    @csrf
    <fieldset class="py-4 w-100">
        <label for="tariff-select" id="tariff" class="text-lg font-medium pr-2 w-full block md:inline-block md:w-24">{{ __('Tariff') }}:</label>
        <select id="tariff-select" name="tariff"
            class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md w-full block md:w-[340px]">
            @php
                $options = [
                    '01' => __('01 - Single Rate Domestic Use'),
                    '02' => __('02 - Two Rate Domestic Use'),
                    '08' => __('08 - Special for Vulnerable Customers'),
                ];
                $selectedValue = old('tariff', $values['tariff'] ?? '01');
            @endphp

            @foreach($options as $value => $label)
                <option value="{{ $value }}" @if($selectedValue == $value) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
        <label for="period" class="text-lg font-medium pr-2 pl-2 mt-4 w-full block md:inline md:w-auto">{{ __('Month') }}:</label>
        <select id="period" name="period"
            class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md w-full block md:inline md:w-44">
            @php
                $options = [
                    '2023-01' => __('January') . ' 2023',
                    '2023-02' => __('February') . ' 2023',
                    '2023-03' => __('March') .  ' 2023',
                    '2023-04' => __('April') . ' 2023',
                    '2023-05' => __('May') . ' 2023',
                    '2023-06' => __('June') . ' 2023',
                    '2023-07' => __('July') . ' 2023',
                    '2023-08' => __('August') . ' 2023',
                    '2023-09' => __('September') . ' 2023',
                    '2023-10' => __('October') . ' 2023',
                    '2023-11' => __('November') . ' 2023',
                    '2023-12' => __('December') . ' 2023',
                ];
                $selectedValue = old('period', $values['period'] ?? '2023-12');
            @endphp

            @foreach($options as $value => $label)
                <option value="{{ $value }}" @if($selectedValue == $value) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
    </fieldset>
    <fieldset id="tariff01" class="{{ (isset($values) && in_array($values['tariff'], ['01', '08'])) || !isset($values) ? 'block' : 'hidden' }}">
        <div class="w-100">
                <label for="consumption" class="text-lg font-medium pr-20 w-full block md:inline-block md:w-96">{{ __('Consumption') }} (kWh):</label>
            <input id="consumption" type="number" name="consumption" step="0.01" min="0" placeholder="0" value="{{ old('consumption', $values['consumption'] ?? 0) }}"
            class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md w-full md:w-[311px]">
        </div>
        <div class="w-100 py-4">
                <label for="credit-amount" class="text-lg font-medium pr-4 w-full block md:inline-block md:w-96">{{ __('Returned Solar Power') }} (kWh):</label>
            <input id="credit-amount" type="number" name="credit-amount" step="0.01" min="0" placeholder="0" value="{{ old('credit-amount', $values['credit-amount'] ?? 0) }}"
            class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md w-full md:w-[311px]">
        </div>
    </fieldset>

    <fieldset id="tariff02" class="{{ (isset($values) && $values['tariff'] === '02') ? 'block' : 'hidden' }}">
        <div class="w-100">
                <label for="consumption-standard" class="text-lg font-medium pr-5 w-full block md:inline-block md:w-[495px]">{{ __('Consumption During Standard Period') }} 09:00-23:00 (kWh):</label>
            <input id="consumption-standard" type="number" name="consumption-standard" step="0.01" min="0" placeholder="0" value="{{ old('consumption-standard', $values['consumption-standard'] ?? 0) }}"
            class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md w-full md:w-[200px]">
        </div>
        <div class="w-100 py-4">
                <label for="consumption-economy" class="text-lg font-medium pr-4 w-full block md:inline-block md:w-[495px]">{{ __('Consumption During Economy Period') }} 23:00-09:00 (kWh):</label>
            <input id="consumption-economy" type="number" name="consumption-economy" step="0.01" min="0" placeholder="0" value="{{ old('consumption-economy', $values['consumption-economy'] ?? 0) }}"
            class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md w-full md:w-[200px]">
        </div>
    </fieldset>
    <fieldset class="py-1">
        <label for="include-fixed" class="text-lg font-medium pr-4 inline-block">{{ __("Include Fixed Costs") }}:</label>
        <input id="include-fixed" type="checkbox" name="include-fixed" value="1" @if(old('include-fixed', $values['include-fixed'] ?? 1)) checked @endif
        class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-md"/>
    </fieldset>

    <x-primary-button class="mt-4">{{ __('Calculate') }}</x-primary-button>

</form>
<div id="tour" class="px-5 mb-12 cursor-pointer" onclick="tour.start()">
    <div class="font-bold text-white bg-blue-700 inline-block px-2 py-1 px-3 rounded-full text-xl shadow-md ml-2 mb-2 md:mb-0 leading-none">?</div>
    <span class="text-lg text-blue-700 font-bold underline">{{ __('How to use the Calculator') }}</span>
</div>
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
<script type="module">
    tour = introJs().setOptions({
        steps: [
        {
            element: document.querySelector('#tariff-select'),
            title: '{{ __('Tariff') }}',
            intro: '{{ __('The tariff is in the top left corner of your bill') }}: <br/><img src="/images/EAC-Tariff-en.png" alt="{{ __('Tariff') }}"/>'
        },
        {
            title: '{{ __('Month') }}',
            element: document.querySelector('#period'),
            intro: '{{ __('Select the month your bill was issued. This is the second date of the period') }}:<br/><img src="/images/EAC-Period-en.png" alt="{{ __('Tariff') }}"/>'
        }]
    });
</script>
