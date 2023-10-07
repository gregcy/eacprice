import Chart from 'chart.js/auto';

const labels = [
    'Energy Charge',
    'Network Charge',
    'Ancilary Services',
    'Public Service Obligation',
];

const data = {
    labels: labels,
    datasets: [{
        label: 'Electricity Cost',
        data: [10, 3, 1, 2]
    }],
};
const config = {
    type: 'doughnut',
    data: data,
};
new Chart(
    document.getElementById('myChart'),
    config
);
