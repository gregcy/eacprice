<div class="w-full">
        <h2 class="text-xl font-bold py-4">Your Electricity Cost</h2>
        <div class="flex pb-6">
            <div class="font-bold">Tariff:</div><div class="font-normal pl-1">{{ $values['tariff'] }}</div>
            @if($values['tariff'] === '01' || $values['tariff'] === '08')
                <div class="font-bold pl-4">Consumption:</div><div class="font-normal pl-1">{{ $values['consumption'] }} kWh</div>
                <div class="font-bold pl-4">Returned Solar Power:</div><div class="font-normal pl-1">{{ $values['credit-amount'] }} kWh</div>
            @elseif($values['tariff'] === '02')
                <div class="font-bold pl-4">Consumption During Standard Period:</div><div class="font-normal pl-1">{{ $values['consumption-standard'] }} kWh</div>
                <div class="font-bold pl-4">Consumption During Economy Period:</div><div class="font-normal pl-1">{{ $values['consumption-economy'] }} kWh</div>
            @endif
        </div>
    </div>
<div class="flex">
    <div class="w-96 mr-12">
        <canvas id="myChart"></canvas>
    </div>
    <div class="w-1/2 ml-16 mt-8">
        <table id="costBreakdown">
            <tr>
                <th class="py-2 px-4 text-left border-transparent"></th>
                <th class="py-2 px-4 text-left">Item</th>
                <th class="py-2 px-4 text-left">Cost</th>
            </tr>
            @isset($cost['energyCharge'])
                <tr class="mx-2">
                    <td class="px-4 border-gray-100 border-b-8 border-t-8"></td>
                    <td class="px-4">Energy Charge</td>
                    <td class="px-4">€{{ $cost['energyCharge'] }}</td>
                </tr>
            @endisset
            @isset($cost['networkCharge'])
                <tr>
                    <td class="px-4 border-gray-100 border-b-8 border-t-8"></td>
                    <td class="px-4">Network Charge</td>
                    <td class="px-4">€{{ $cost['networkCharge'] }}</td>
                </tr>
            @endisset
            @isset($cost['ancilaryServices'])
                <tr>
                    <td class="px-4 border-gray-100 border-b-8 border-t-8"></td>
                    <td class="px-4">Ancillary Services</td>
                    <td class="px-4">€{{ $cost['ancilaryServices'] }}</td>
                </tr>
            @endisset
            @isset($cost['publicServiceObligation'])
                <tr>
                    <td class="px-4 border-gray-100 border-b-8 border-t-8"></td>
                    <td class="px-4">Public Service Obligation</td>
                    <td class="px-4">€{{ $cost['publicServiceObligation'] }}</td>
                </tr>
            @endisset
            @isset($cost['fuelAdjustment'])
                <tr>
                    <td class="px-4 border-gray-100 border-b-8 border-t-8"></td>
                    <td class="px-4">Fuel Adjustment</td>
                    <td class="px-4">€{{ $cost['fuelAdjustment'] }}</td>
                </tr>
            @endisset
            @isset($cost['supplyCharge'])
                <tr>
                    <td class="px-4 border-gray-100 border-b-8 border-t-8"></td>
                    <td class="px-4">Supply Charge</td>
                    <td class="px-4">€{{ $cost['supplyCharge'] }}</td>
                </tr>
            @endisset
            @isset($cost['meterReaading'])
                <tr>
                    <td class="px-4 border-gray-100 border-b-8 border-t-8"></td>
                    <td class="px-4">Meter Reading</td>
                    <td class="px-4">€{{ $cost['meterReaading'] }}</td>
                </tr>
            @endisset
            <tr>
                <td class="px-4 border-gray-100 border-b-8 border-t-8"></td>
                <td class="px-4">VAT</td>
                <td class="px-4">€{{ $cost['vat'] }}</td>
            </tr>
            <tr>
                <td class="px-4 border-transparent"></td>
                <td class="py-2 px-4 font-bold">Total:</td>
                <td class="py-2 px-4 font-bold">€{{ $cost['total']}}</td>
            </tr>
        </table>
    </div>
</div>
<script type="module">
    const total = {{ number_format($cost['total'],2,'.','') }};
    const data = {
        labels: [
            @isset($cost['energyCharge'])
                'Energy Charge',
            @endisset
            @isset($cost['networkCharge'])
                'Network Charge',
            @endisset
            @isset($cost['ancilaryServices'])
                'Ancillary Services',
            @endisset
            @isset($cost['publicServiceObligation'])
                'Public Service Obligation',
            @endisset
            @isset($cost['fuelAdjustment'])
                'Fuel Adjustment',
            @endisset
            @isset($cost['supplyCharge'])
                'Supply Charge',
            @endisset
            @isset($cost['meterReaading'])
                'Meter Reading',
            @endisset
            'VAT'],
        datasets: [{
            label: 'Cost',
            data: [
                @php
                    array_pop($cost);
                    echo implode(',', $cost);
                @endphp
            ],
            borderWidth: 1
        }]
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

