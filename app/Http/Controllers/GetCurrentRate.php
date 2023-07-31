<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adjustment;
use App\Models\Tariff;

class GetCurrentRate extends Controller
{
    public function index(Request $request, string $tariffCode, bool $creditUnits)
    {
        $validated = $request->validate(
            [
                'tariffCode' => 'required|in["01", "02", "08"]',
                'creditUnits' => 'nullable|boolean',
            ]
        );
    }
}
