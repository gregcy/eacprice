<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\EACTrait;
use App\Models\Cost;

class CalculatorController extends Controller
{
    use EACTrait;

    public function index(): View
    {
        return view('calculator.page');
    }

    public function calculate(Request $request): View
    {
        $validated = $request->validate(
            [
                // '01' => 'Single Rate Domestic Use', '02' => 'Two Rate Domestic Use', '08' => 'Special Tariff for Vulnerable Customers
                'tariff' => 'required|in:01,02,08',
                'consumption' => 'nullable|numeric|gte:0',
                'credit-amount' => 'nullable|numeric|gte:0',
                'consumption-standard' => 'nullable|numeric|gte:0',
                'consumption-economy' => 'nullable|numeric|gte:0',
            ]
        );

        $cost = [];
        $values = array('tariff' => $validated['tariff'],
                        'consumption' => $validated['consumption'] ?? 0,
                        'credit-amount' => $validated['credit-amount'] ?? 0,
                        'consumption-standard' => $validated['consumption-standard'] ?? 0,
                        'consumption-economy' => $validated['consumption-economy'] ?? 0);

        if ($validated['tariff'] == "01") {
            $cost = $this->calculateEACCost01(
                $values['consumption'],
                $values['credit-amount'],
                date_create('now'),
                date_create('now')
            );
        } else if ($validated['tariff'] == "02") {
            $cost = $this->calculateEACCost02(
                $values['consumption-standard'],
                $values['consumption-economy'],
                date_create('now'),
                date_create('now')
            );
        } else if ($validated['tariff'] == "08") {
            $cost = $this->calculateEACCost08(
                $values['consumption'],
                $values['credit-amount'],
                date_create('now'),
                date_create('now')
            );
        }


        foreach ($cost as $key => $value) {
            if ($key != 'sources') {
                $cost[$key] = $this->min_precision($value, 2);
            }
        }

        $vat_rate = Cost::where('name', 'vat')
            ->where('end_date', '=', null)
            ->first();

        $sources = array_pop($cost);
        return view(
            'calculator.page',
            [
                'cost' => $cost,
                'values' => $values,
                'vat_rate' => number_format($vat_rate->value*100, 0, '.', ''),
                'sources' => $sources
            ]
        );
    }

    private function min_precision($x, $p)
    {
        $e = pow(10,$p);
        return floor($x*$e)==$x*$e?sprintf("%.${p}f",$x):$x;
    }
}
