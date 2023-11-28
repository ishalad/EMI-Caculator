<?php

use App\Http\Controllers\EMILoanCalculatorController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/loan-calculator', [EMILoanCalculatorController::class, 'index']);
Route::post('/loan-calculator/calculate', [EMILoanCalculatorController::class, 'calculate']);
Route::get('/loan-calculator/history/{id}', [EMILoanCalculatorController::class, 'getHistory']);
