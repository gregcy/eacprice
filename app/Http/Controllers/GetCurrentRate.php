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

        $dateNow = date('Y-m-d', time());
        $adjustment = Adjustment::where('consumer_type', $billing)
             ->where('start_date', '<=', $dateNow)
             ->where('end_date', '>=', $dateNow)
            ->first();
        $tariff = Tariff::where('code', $tariffCode)
            ->where('end_date', '=',0)
            ->first();
        return response()->json(['Tariff Code' => $tariffCode, 'Billing' => $billing, 'Credit Units' => $creditUnits],200);
    }
}
