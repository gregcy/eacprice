<div class="flex">
    <div class="w-96">
        <canvas id="myChart"></canvas>
    </div>
    <div class="w-96 ml-16 mt-8">
        <table>
            <tr>
                <th class="py-2 px-4 text-left">Item</th>
                <th class="py-2 px-4 text-left">Cost</th>
            </tr>
            <tr>
                <td class="px-4">Energy Charge</td>
                <td class="px-4">€10.35</td>
            </tr>
            <tr>
                <td class="px-4">Network Charge</td>
                <td class="px-4">€3.02</td>
            </tr>
            <tr>
                <td class="px-4">Ancillary Services</td>
                <td class="px-4">€0.65</td>
            </tr>
            <tr>
                <td class="px-4">Public Service Obligation</td>
                <td class="px-4">€0.058</td>
            </tr>
            <tr>
                <td class="px-4">Fuel Adjustement</td>
                <td class="px-4">€6.3378</td>
            </tr>
            <tr>
                <td class="px-4">VAT</td>
                <td class="px-4">€7.0248</td>
            </tr>
            <tr>
                <td class="py-2 px-4 font-bold">Total:</td>
                <td class="py-2 px-4 font-bold">€102.33</td>
            </tr>
        </table>
    </div>
</div>
<script type="module">
    const data = {
        labels: ['Energy Charge', 'Network Charge', 'Ancillary Services', 'Public Service Obligation', 'Fuel Adjustement', 'VAT'],
        datasets: [{
            label: '€',
            data: [10.35, 3.02, 0.65, 0.058, 6.3378, 7.0248],
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
            ctx.fillText('€10,002.33', xCoor, yCoor);
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
            }
        },
        plugins: [doughnutLabel]
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

</script>

