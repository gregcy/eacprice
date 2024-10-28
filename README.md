<table>
<tr>
    <td>
        <img src="https://raw.githubusercontent.com/gregcy/eacprice/master/public/images/calculator.webp" width="100" alt="Cyprus Electricity Calculator">
    </td>
    <td>
        <h1>Cyprus Electricity Calculator</h1>
    </td>
</tr>
</table>

## About the Cyprus Electricity Calculator

The Cyprus Electricity Calculator is a web application that allows users to calculate the cost of electricity in Cyprus. The application is built using the Laravel PHP framework.

There are two ways to get information about electricity costs. 
1. Use the calculator available on the web interface. 
2. Access the information via the API.

There is a filament based administration interface that allows the management of the tariffs and prices used by the application to perform the calculations.

You can see a live version of the application at [https://electricity-calculator.cy/](https://electricity-calculator.cy/)
 

## Installation/Setup

This is a standard Laravel application. The following steps should be sufficient to get the application up and running. You will need to have a database setup and the relevant credentials available.

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
