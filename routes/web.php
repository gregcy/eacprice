<?php

use App\Http\Controllers\AdjustmentController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\CostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CalculatorController::class, 'index']);
Route::get('{lang?}/', [CalculatorController::class, 'index']);
Route::post('{lang?}/', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

Route::get(
    '/dashboard', function () {
        return view('dashboard');
    }
)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(
    function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    }
);

Route::resource('adjustments', AdjustmentController::class)
    ->only(['index', 'store', 'edit', 'update', 'create', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('tariffs', TariffController::class)
    ->only(['index', 'store', 'edit', 'update', 'create', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('costs', CostController::class)
    ->only(['index', 'store', 'edit', 'update', 'create', 'destroy'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
