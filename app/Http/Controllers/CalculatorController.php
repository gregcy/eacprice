<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\EACTrait;

class CalculatorController extends Controller
{
    public function index(): View
    {
        return view('rate.calculator');
    }

    public function calculate(Request $request): View
    {
        dd($request);
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


        return view(
            'rate.calculate',
            [

            ]
        );
    }
}
