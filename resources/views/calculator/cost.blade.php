<div class="w-full bg-white p-6">
    <h2 class="text-xl font-bold py-4">Your Electricity Cost</h2>
    <div class="flex flex-wrap pb-6">
        <div class="w-full md:w-auto pr-4"><span class="font-bold">Tariff:</span><span class="font-normal pl-1">{{ $values['tariff'] }}</span></div>
        @if($values['tariff'] === '01' || $values['tariff'] === '08')
        <div class="w-full md:w-auto pr-4"><span class="font-bold">Consumption:</span><span class="font-normal pl-1">{{ $values['consumption'] }} kWh</span></span></div>
        <div class="w-full md:w-auto pr-4"><span class="font-bold">Returned Solar Power:</span><span class="font-normal pl-1">{{ $values['credit-amount'] }} kWh</span></div>
        @elseif($values['tariff'] === '02')
        <div class="w-full md:w-auto pr-4"><span class="font-bold pl-4">Consumption During Standard Period:</span><span class="font-normal pl-1">{{ $values['consumption-standard'] }} kWh</span></div>
        <div class="w-full md:w-auto pr-4"><span class="font-bold pl-4">Consumption During Economy Period:</span><span class="font-normal pl-1">{{ $values['consumption-economy'] }} kWh</span></div>
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
                <th class="py-2 px-2 text-left">Item</th>
                <th class="py-2 px-2 text-left">Cost</th>
                <th class="py-2 px-2 text-left border-transparent"></th>
            </tr>
            @isset($cost['energyCharge'])
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">Energy Charge</td>
                    <td class="px-2">€{{ $cost['energyCharge'] }}</td>
                    <td><span class="my-2 bg-blue-500 px-2 text-white font-black text-center rounded-full text-2xl">?</span></td>
                </tr>
                <dialog><p>Source: <a href="{{ $cost['source']}}">EAC Tariff</a></p></dialog>
            @endisset
            @isset($cost['networkCharge'])
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">Network Charge</td>
                    <td class="px-2">€{{ $cost['networkCharge'] }}</td>
                    <td><span class="my-2 bg-blue-500 px-2 text-white font-black text-center rounded-full text-2xl">?</span></td>
                </tr>
            @endisset
            @isset($cost['ancilaryServices'])
                <tr>
                    <td class="px-41 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">Ancillary Services</td>
                    <td class="px-2">€{{ $cost['ancilaryServices'] }}</td>
                    <td><span class="my-2 bg-blue-500 px-2 text-white font-black text-center rounded-full text-2xl">?</span></td>
                </tr>
            @endisset
            @isset($cost['publicServiceObligation'])
                <tr>
                    <td class="px-41 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">Public Service Obligation</td>
                    <td class="px-2">€{{ $cost['publicServiceObligation'] }}</td>
                    <td><span class="my-2 bg-blue-500 px-2 text-white font-black text-center rounded-full text-2xl">?</span></td>
                </tr>
            @endisset
            @isset($cost['fuelAdjustment'])
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">Fuel Adjustment</td>
                    <td class="px-2">€{{ $cost['fuelAdjustment'] }}</td>
                    <td><span class="my-2 bg-blue-500 px-2 text-white font-black text-center rounded-full text-2xl">?</span></td>
                </tr>
            @endisset
            @isset($cost['supplyCharge'])
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">Supply Charge</td>
                    <td class="px-2">€{{ $cost['supplyCharge'] }}</td>
                    <td><span class="my-2 bg-blue-500 px-2 text-white font-black text-center rounded-full text-2xl">?</span></td>
                </tr>
            @endisset
            @isset($cost['meterReaading'])
                <tr>
                    <td class="px-4 border-white border-b-8 border-t-8"></td>
                    <td class="px-2">Meter Reading</td>
                    <td class="px-2">€{{ $cost['meterReaading'] }}</td>
                    <td><span class="my-2 bg-blue-500 px-2 text-white font-black text-center rounded-full text-2xl">?</span></td>
                </tr>
            @endisset
            <tr>
                <td class="px-4 border-white border-b-8 border-t-8"></td>
                <td class="px-2">VAT</td>
                <td class="px-2">€{{ $cost['vat'] }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="px-4 border-transparent"></td>
                <td class="py-2 px-2 font-bold">Total:</td>
                <td class="py-2 px-2 font-bold">€{{ $cost['total']}}</td>
                <td></td>

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
            backgroundColor: [
            '#36a2eb',
            '#ff6384',
            '#ff9f40',
            '#ffe29d',
            '#4bc0c0',
            '#9966ff',
            '#c8cace',
            '#4FF0CE'
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

