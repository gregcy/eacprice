<div class="w-full bg-white p-6">
    <h2 class="text-xl font-bold py-4">{{ __('Your Electricity Cost') }}</h2>
    <div class="flex flex-wrap pb-6">
        <div class="w-full md:w-auto pr-4"><span class="font-bold">{{ __('Tariff') }}:</span><span class="font-normal pl-1">{{ $values['tariff'] }}</span></div>
        @if($values['tariff'] === '01' || $values['tariff'] === '08')
        <div class="w-full md:w-auto pr-4"><span class="font-bold">{{ __('Consumption') }}:</span><span class="font-normal pl-1">{{ $values['consumption'] }} kWh</span></span></div>
        <div class="w-full md:w-auto pr-4"><span class="font-bold">{{ __('Returned Solar Power') }}:</span><span class="font-normal pl-1">{{ $values['credit-amount'] }} kWh</span></div>
        @elseif($values['tariff'] === '02')
        <div class="w-full md:w-auto pr-4"><span class="font-bold pl-4">{{ __('Consumption During Standard Period') }}:</span><span class="font-normal pl-1">{{ $values['consumption-standard'] }} kWh</span></div>
        <div class="w-full md:w-auto pr-4"><span class="font-bold pl-4">{{ __('Consumption During Economy Period') }}:</span><span class="font-normal pl-1">{{ $values['consumption-economy'] }} kWh</span></div>
        @endif
    </div>
</div>
<div class="flex flex-wrap bg-white p-6">
    <div class="w-full lg:w-96 mr-0 lg:mr-12 inline-flex items-center justify-center">
        <canvas id="myChart"></canvas>
    </div>
    <div class="w-full lg:w-96 ml-0 lg:ml-16 mt-8 inline-flex items-center justify-center">
        <table id="costBreakdown">
            @foreach($cost as $key => $value)
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8" style="background-color: {{ $value->color }}"></td>
                    <td class="px-2">{{ __($value->description) }}
                    @if(isset($value->source))
                        <sup class="pl-2">1</sup>
                    @endif
                    </td>
                    <td class="px-2 font-mono">€{{ $value->value }}</td>
                </tr>
            @endforeach
        </table>
    </div>

</div>
