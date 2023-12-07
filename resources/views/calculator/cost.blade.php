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
                    @if($key != 'total')
                        <td class="px-2">{{ __($value->description) }}
                    @else
                    <td class="px-2 font-bold">{{ __($value->description) }}:
                    @endif
                    @if(isset($value->source))
                        <sup class="pl-2">{{ $value->source['superscript'] }}</sup>
                    @endif
                    </td>
                    @if($key != 'total')
                    <td class="px-2 font-mono text-right text-sm">€{{ $value->value }}</td>
                    @else
                    <td class="px-2 font-mono font-bold text-right text-sm">€{{ __($value->value) }}
                    @endif
                </tr>
            @endforeach
            @foreach ($sources as $key => $value)
                <tr>
                    <td colspan="3" class="text-xs"><a href="{{ $value['link'] }}" target="_blank">{{ $key}}. {{ __($value['description']) }}</a></td>
                </tr>
            @endforeach
        </table>
    </div>
    <script type="module">
        const total = {{ number_format($cost['total']->value, 2, '.', '') }};
        const data = {
            labels: [
                @foreach($cost as $key => $value)
                    @if($key != 'total')
                        '{{ $value->description }}',
                    @endif
                @endforeach
            ],
            datasets: [{
                label: '{{ __('Cost') }}',
                data: [
                    @foreach($cost as $key => $value)
                    @if($key != 'total')
                        '{{ $value->value }}',
                    @endif
                @endforeach
                ],
                backgroundColor: [
                    @foreach($cost as $key => $value)
                        @if($key != 'total')
                            '{{ $value->color }}',
                        @endif
                    @endforeach
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

</div>
