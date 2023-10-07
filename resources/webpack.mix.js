const mix = require('laravel-mix');
const path = require('path');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve('resources/js'),
                'chart.js': 'chart.js/dist/Chart.js' // add this line to load chart.js
            }
        }
    });
