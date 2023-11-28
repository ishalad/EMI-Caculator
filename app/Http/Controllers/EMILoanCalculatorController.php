<?php

namespace App\Http\Controllers;

use App\Models\LoanCalculation;
use Illuminate\Http\Request;

class EMILoanCalculatorController extends Controller
{
    public function index() {
        return view('loan-calculator.index');
    }

    public function calculateEMI(Request $request)
    {
    	$validateData = $request->validate([
    		'principal_amt' => 'required|integer',
    		'rate' => 'required|numaric',
    		'duration' => 'required|integer',
    	]);

    	LoanCalculation::create($validateData);
    	 return view('loan-calculator.result', [
            'emiData' => $emiData,
            'history' => LoanCalculation::latest()->take(10)->get(),
        ]);
    }

    public function getHistory($id)
	{
	    $calculation = LoanCalculation::findOrFail($id);

	    return response()->json([
	        'emiData' => $calculation->emiData,
	    ]);
	}

}
