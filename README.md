<div style="margin: 15px; display: flex; justify-content: center; align-items: center; min-height: 100px">
    <div style="display: flex; align-items: center;">
        <img src="https://raw.githubusercontent.com/gregcy/eacprice/master/public/images/calculator.png" width="100" alt="Cyprus Electricity Calculator" style="width: 100px; height: auto; margin-right: 10px;">
        <h1 style="margin: 0;">Cyprus Electricity Calculator</h1>
    </div>
</div>
<p align="center">


## About the Cyprus Electricity Calculator

The Cyprus Electricity Calculator is a web application that allows users to calculate the cost of electricity in Cyprus. The application is built using the Laravel PHP framework.

There are two ways to get information about the cost of electricity. The first is to use the calculator available on the web interface. The second is to use the API.

There is a basic administration interface that allows the management of the EAC tariffs and prices used by the application.

You can see a live version of the application at [https://eac.greg.cy](https://eac.greg.cy).


## Installation/Setup

This is a standard Laravel application. The following steps should be sufficient to get the application up and running. Please note that you will need to have a database setup and the relevant credentials available.

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Copy the `.env.example` file to `.env` and customise
5. Run `php artisan migrate`
6. Run `php artisan serve`
7. run `npm run dev`

Please note that the registration of new users is disabled by default. To enable this you will need to uncomment the relevant code in the `routes/auth.php` file (lines 15-18).



## License

The Cyprus Electricity Calculator is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
