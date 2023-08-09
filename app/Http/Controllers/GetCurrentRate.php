<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adjustment;
use App\Models\Tariff;
use Illuminate\Validation\Rule;

class GetCurrentRate extends Controller
{
    public function index(Request $request)
    {
        try {
            $validated = $request->validate(
                [
                    'tariffCode' => [Rule::in(["01", "02", "08"])],
                    'billing' => [Rule::in(["Monthly", "Bi-Monthly"])],
                    'creditUnits' => 'boolean',
                ]
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
        $tariffCode = request('tariffCode','01');
        $billing = request('billing','Bi-Monthly');
        $creditUnits = request('creditUnits',false);
        return response()->json(['Tariff Code' => $tariffCode, 'Billing' => $billing, 'Credit Units' => $creditUnits],200);
    }
}
