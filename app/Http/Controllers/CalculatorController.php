<?php

namespace App\Http\Controllers;

use App\Traits\EACTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;
use NumberFormatter;

/**
 * Caclculator Controller
 * {@inheritdoc}
 */
class CalculatorController extends Controller
{
    use EACTrait;

    /**
     * Display the elctricity cost calculator.
     */
    public function index(): View
    {
        return view('calculator.page');
    }

    public function calculate(Request $request): View
    {
        $validated = $request->validate(
            [
                /*
                 *'01' => 'Single Rate Domestic Use',
                 *'02' => 'Two Rate Domestic Use',
                 *'08' => 'Special Tariff for Vulnerable Customers
                */
                'tariff' => 'required|in:01,02,08',
                'consumption' => 'nullable|numeric|gte:0',
                'credit-amount' => 'nullable|numeric|gte:0',
                'consumption-standard' => 'nullable|numeric|gte:0',
                'consumption-economy' => 'nullable|numeric|gte:0',
                'period' => 'required|in:2023-01,2023-02,2023-03,2023-04,
                    2023-05,2023-06,2023-07,2023-08,2023-09,
                    2023-10,2023-11,2023-12,2024-01,2024-02,2024-03',
                'include-fixed' => 'nullable|boolean',
            ]
        );

        $values = [
            'tariff' => $validated['tariff'],
            'consumption' => $validated['consumption'] ?? 0,
            'credit-amount' => $validated['credit-amount'] ?? 0,
            'consumption-standard' => $validated['consumption-standard'] ?? 0,
            'consumption-economy' => $validated['consumption-economy'] ?? 0,
            'include-fixed' => $validated['include-fixed'] ?? 0,
            'date-start' => date_create_from_format(
                'Y-m',
                $validated['period']
            )
            ?? date_create('now'),
            'date-end' => date_create_from_format(
                'Y-m',
                $validated['period']
            )
            ?? date_create('now'),
            'period' => $validated['period'],
        ];

        if ($validated['tariff'] == '01') {
            $cost = $this->calculateEACCost01(
                $values['consumption'],
                $values['credit-amount'],
                $values['include-fixed'],
                $values['date-start'],
                $values['date-end']
            );
        } elseif ($validated['tariff'] == '02') {
            $cost = $this->calculateEACCost02(
                $values['consumption-standard'],
                $values['consumption-economy'],
                $values['include-fixed'],
                $values['date-start'],
                $values['date-end']
            );
        } elseif ($validated['tariff'] == '08') {
            $cost = $this->calculateEACCost08(
                $values['consumption'],
                $values['credit-amount'],
                $values['include-fixed'],
                $values['date-start'],
                $values['date-end']
            );
        }
        $sources = $cost->getSourceList();
        $formattedCost = $this->formatCostsCalculator($cost);
        $currencyFormatter = numfmt_create('en', NumberFormatter::CURRENCY);
        foreach ($formattedCost as $key => $value) {
            if (isset($value->value)) {
                $formattedCost[$key]->value = numfmt_format_currency(
                    $currencyFormatter,
                    $value->value,
                    'EUR'
                );
            }
        }
        $vat_rate = $this->getVatRate(
            $values['date-start'],
            $values['date-end'],
            $validated['tariff']
        );
        $vat_rate = number_format($vat_rate->value * 100, 0, '.', '');

        return view(
            'calculator.page',
            [
                'cost' => $formattedCost,
                'values' => $values,
                'vat_rate' => $vat_rate,
                'sources' => $sources,
            ]
        );
    }
}
