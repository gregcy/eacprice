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
                'period' => 'required|in:2023-01,2023-02,2023-03,2023-04,2023-05,2023-06,2023-07,2023-08,2023-09,2023-10,2023-11',
                'include-fixed' => 'nullable|boolean',
            ]
        );

        $cost = [];
        $values = array(
            'tariff' => $validated['tariff'],
            'consumption' => $validated['consumption'] ?? 0,
            'credit-amount' => $validated['credit-amount'] ?? 0,
            'consumption-standard' => $validated['consumption-standard'] ?? 0,
            'consumption-economy' => $validated['consumption-economy'] ?? 0,
            'include-fixed' => $validated['include-fixed'] ?? 0,
            'date-start' => date_create_from_format('Y-m', $validated['period']) ?? date_create('now'),
            'date-end' => date_create_from_format('Y-m', $validated['period']) ?? date_create('now'),
            'period' => $validated['period']
        );


        if ($validated['tariff'] == "01") {
            $cost = $this->calculateEACCost01(
                $values['consumption'],
                $values['credit-amount'],
                $values['include-fixed'],
                $values['date-start'],
                $values['date-end']
            );
        } else if ($validated['tariff'] == "02") {
            $cost = $this->calculateEACCost02(
                $values['consumption-standard'],
                $values['consumption-economy'],
                $values['include-fixed'],
                $values['date-start'],
                $values['date-end']
            );
        } else if ($validated['tariff'] == "08") {
            $cost = $this->calculateEACCost08(
                $values['consumption'],
                $values['credit-amount'],
                $values['include-fixed'],
                $values['date-start'],
                $values['date-end']
            );
        }
        foreach ($cost as $key => $value) {
            if (isset($value->value)) {
                $cost[$key]->value = $this->min_precision($value->value, 2);
            }
        }
        $vat_rate = $this->getVatRate($values['date-start'], $values['date-end'], $validated['tariff']);
        $vat_rate = number_format($vat_rate->value*100, 0, '.', '');

        $sources = array_pop($cost);
        return view(
            'calculator.page',
            [
                'cost' => $cost,
                'values' => $values,
                'vat_rate' => $vat_rate,
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
