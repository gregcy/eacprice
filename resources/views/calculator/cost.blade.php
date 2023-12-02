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
            <tr>
                <th class="py-2 px-4 text-left border-transparent"></th>
                <th class="py-2 px-2 text-left">{{ __('Item') }}</th>
                <th class="py-2 px-2 text-left">{{ __('Cost') }}</th>
            </tr>
            @isset($cost['energyCharge'])
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">{{ __('Electricity Generation') }}<sup class="pl-2">1</sup></td>
                    <td class="px-2">€{{ $cost['energyCharge'] }}</td>
                </tr>
            @endisset
            @isset($cost['networkCharge'])
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">{{ __('Network Usage') }}<sup class="pl-2">1</sup></td>
                    <td class="px-2">€{{ $cost['networkCharge'] }}</td>
                </tr>
            @endisset
            @isset($cost['ancillaryServices'])
                <tr>
                    <td class="px-41 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">{{ __('Ancillary Services') }}<sup class="pl-2">1</sup></td>
                    <td class="px-2">€{{ $cost['ancillaryServices'] }}</td>
                </tr>
            @endisset
            @isset($cost['meterReading'])
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">{{ __('Meter Reading') }}<sup class="pl-2">1</sup></td>
                    <td class="px-2">€{{ $cost['meterReading'] }}</td>
                </tr>
            @endisset
            @isset($cost['supplyCharge'])
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">{{ __('Supply Charge') }}<sup class="pl-2">1</sup></td>
                    <td class="px-2">€{{ $cost['supplyCharge'] }}</td>
                </tr>
            @endisset
            @isset($cost['fuelAdjustment'])
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">{{ __('Fuel Adjustment') }}<sup class="pl-2">2</sup></td>
                    <td class="px-2">€{{ $cost['fuelAdjustment'] }}</td>
                </tr>
            @endisset
            @isset($cost['publicServiceObligation'])
                <tr>
                    <td class="px-41 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">{{ __('Public Service Obligation') }}<sup class="pl-2">{{ count($sources) }}</sup></td>
                    <td class="px-2">€{{ $cost['publicServiceObligation'] }}</td>
                </tr>
            @endisset
            @isset($cost['resEsFund'])
                <tr>
                    <td class="px-41 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">{{ __('RES & ES Fund') }}<sup class="pl-2">{{ count($sources) }}</sup></td>
                    <td class="px-2">€{{ $cost['resEsFund'] }}</td>
                </tr>
            @endisset
            <tr>
                <td class="px-4 border-white border-b-8 border-t-8"></td>
                <td class="px-2">{{ __('VAT') }} {{ $vat_rate }}%</td>
                <td class="px-2">€{{ $cost['vat'] }}</td>
            </tr>
            <tr>
                <td class="px-4 border-transparent"></td>
                <td class="py-2 px-2 font-bold">{{ __('Total:') }}</td>
                <td class="py-2 px-2 font-bold">€{{ $cost['total']}}</td>
            </tr>
             @if (count($sources) == 1)
                <tr>
                    <td colspan="3" class="text-xs"><a href="{{ $sources[0] }}" target="_blank">1. {{ __('Domestic Use Tariffs') }}</a></td>
                </tr>
            @elseif (count($sources) == 2)
                @if ($values['tariff'] === '01')
                    <tr>
                        <td colspan="3" class="text-xs"><a href="{{ $sources[0] }}" target="_blank">1. {{ __('Domestic Use Tariffs') }}</a></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-xs"><a href="{{ $sources[1] }}" target="_blank">2. {{ __('Public Service Obligation') }}</a></td>
                    </tr>
                @elseif ($values['tariff'] === '08')
                    <tr>
                        <td colspan="3" class="text-xs"><a href="{{ $sources[0] }}" target="_blank">1. {{ __('Domestic Use Tariffs') }}</a></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-xs"><a href="{{ $sources[1] }}" target="_blank">2. {{ __('Fuel Ajustment Clause') }}</a></td>
                    </tr>
                @endif
            @else
                <tr>
                    <td colspan="3" class="text-xs"><a href="{{ $sources[0] }}" target="_blank">1. {{ __('Domestic Use Tariffs') }}</a></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-xs"><a href="{{ $sources[1] }}" target="_blank">2. {{ __('Fuel Ajustment Clause') }}</a></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-xs"><a href="{{ $sources[2] }}" target="_blank">3. {{ __('Public Service Obligation') }}</a></td>
                </tr>
            @endif
        </table>
    </div>

</div>

<script type="module">
    const total = {{ number_format($cost['total'],2,'.','') }};
    const data = {
        labels: [
            @isset($cost['energyCharge'])
                '{{ __('Electricity Generation') }}',
            @endisset
            @isset($cost['networkCharge'])
                '{{ __('Network Usage') }}',
            @endisset
            @isset($cost['ancillaryServices'])
                '{{ __('Ancillary Services') }}',
            @endisset
            @isset($cost['meterReading'])
                '{{ __('Meter Reading') }}',
            @endisset
            @isset($cost['supplyCharge'])
                '{{ __('Supply Charge') }}',
            @endisset
            @isset($cost['publicServiceObligation'])
                '{{ __('Public Service Obligation') }}',
            @endisset
            @isset($cost['fuelAdjustment'])
                '{{ __('Fuel Adjustment') }}',
            @endisset

            '{{ __('VAT') }}'],
        datasets: [{
            label: '{{ __('Cost') }}',
            data: [
                @php
                    array_pop($cost);
                    echo implode(',', $cost);
                @endphp
            ],
            backgroundColor: [
            '#36a2eb',
            '#ff6384',
            '#ff9f40',
            '#ffe29d',
            '#4bc0c0',
            '#9966ff',
            '#c8cace',
            '#4FF0CE',
            '#388c12'
            ],
            borderWidth: 1
        }],
    };
    const doughnutLabel = {
        id: 'doughnutLabel',
        beforeDatasetsDraw(chart, args, pluginOptions) {
            const { ctx, data} = chart;

            ctx.save();
            const xCoor = chart.getDatasetMeta(0).data[0].x;
            const yCoor = chart.getDatasetMeta(0).data[0].y;
            ctx.font = 'bold 25px sans-serif';
            ctx.fillStyle = 'rgba(54,162,235,1)';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('€'+total.toFixed(2), xCoor, yCoor);
        }
    }
    const config = {
        type: 'doughnut',
        data,
        options: {
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';

                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'EUR' }).format(context.parsed);
                            }
                            return label;
                        }
                    }
                }
            }

        },
        plugins: [doughnutLabel]
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

</script>

