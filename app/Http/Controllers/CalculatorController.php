<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\EACTrait;

class CalculatorController extends Controller
{
    use EACTrait;

    public function index(): View
    {
        return view('rate.page');
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

        if ($validated['tariff'] == "01") {
            $cost = $this->calculateEACCost01(
                $validated['consumption'],
                $validated['credit-amount'],
                date_create('now'),
                date_create('now')
            );
        } else if ($validated['tariff'] == "02") {
            $cost = $this->calculateEACCost02(
                $validated['consumption-standard'],
                $validated['consumption-economy'],
                date_create('now'),
                date_create('now')
            );
        } else if ($validated['tariff'] == "08") {
            $cost = $this->calculateEACCost08(
                $validated['consumption'],
                $validated['credit-amount'],
                date_create('now'),
                date_create('now')
            );
        }

        return view(
            'rate.page',
            [
                'cost' => $cost,
            ]
        );
    }
}
