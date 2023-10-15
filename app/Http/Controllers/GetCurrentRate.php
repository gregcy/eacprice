<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Traits\EACTrait;

class GetCurrentRate extends Controller
{
    use EACTrait;

    public function index(Request $request)
    {
        $json = '';

        try {
            $request->validate(
                [
                    'tariffCode' => [Rule::in(['01', '02', '08'])],
                    'unitsConsumed' => 'numeric|gte:0',
                    'creditUnits' => 'boolean',
                ]
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
        $tariffCode = request('tariffCode', '01');
        $billing = request('billing', 'Bi-Monthly');
        $unitsConsumed = request('unitsConsumed', 1);
        $creditUnits = request('creditUnits', 0);

        if ($tariffCode == '01') {
            if (!$creditUnits) {
                $cost = $this->calculateEACCost01(1, 0, date_create('now'), date_create('now'));

            } else {
                $cost = $this->calculateEACCost01(1, 1, date_create('now'), date_create('now'));
            }
        } else if ($tariffCode == '02') {
            $time_now = date('H') +3 ;
            if ($time_now >= 9 && $time_now < 23) {
                $cost = $this->calculateEACCost02(1, 0, date_create('now'), date_create('now'));
            } else {
                $cost = $this->calculateEACCost02(0, 1, date_create('now'), date_create('now'));
            }

        } else if ($tariffCode == '08') {
            if (!$creditUnits) {
                $cost = $this->calculateEACCost08(1, 0,  date_create('now'), date_create('now'));
            } else {
                $cost = $this->calculateEACCost08(1, 1,  date_create('now'), date_create('now'));
            }
        }

        $json = ['measurement' => '€/kWh', 'cost' => $cost];

        return response()->json(
            $json, 200
        );
    }
}
