<?php

use App\Http\Controllers\EMILoanCalculatorController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/loan-calculator', [EMILoanCalculatorController::class, 'index'])->name('loan_calculation');
Route::post('/loan-calculator/calculate', [EMILoanCalculatorController::class, 'calculateEMI'])->name('calculate');
Route::post('/loan-calculator/history', [EMILoanCalculatorController::class, 'getHistory'])->name('result_EMI');

require __DIR__.'/auth.php';
