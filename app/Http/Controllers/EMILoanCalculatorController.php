<?php

namespace App\Http\Controllers;

use App\Models\LoanCalculation;
use Illuminate\Http\Request;
use Auth;
class EMILoanCalculatorController extends Controller
{
    public function index() {
    	$history = LoanCalculation::where('user_id', Auth::id())->latest()->take(10)->get();
        return view('loan-calculator.index', ['history' => $history]);
    }

    public function calculateEMI(Request $request)
    {
    	try {
    		
	    	$validateData = $request->validate([
	    		'principal_amount' => 'required|integer',
	    		'interest_rate' => 'required|numeric',
	    		'duration' => 'required|integer',
	    	]);
	    	if($validateData) {
	    		$monthlyInterestRate = ($request->interest_rate / 100) / 12;
			    $denominator = pow((1 + $monthlyInterestRate), $request->duration) - 1;
	    		$emiData = number_format((float)$request->principal_amount * ($monthlyInterestRate * pow((1 + $monthlyInterestRate), $request->duration)) / $denominator, 2, '.', '');
	    	}
	    	if($emiData > -1) {
	    		$loan_calculation = new LoanCalculation(); 
	    		$loan_calculation->user_id = Auth::id();
	    		$loan_calculation->principal_amount = $request->principal_amount;
	    		$loan_calculation->interest_rate = $request->interest_rate;
	    		$loan_calculation->duration = $request->duration;
	    		$loan_calculation->emi_amount = $emiData;
	    		$loan_calculation->save();

	    		$history = LoanCalculation::latest()->take(10)->get();
		    	return response()->json(['message' => 'The Emi Amount per month is '.$emiData, 'history' => $loan_calculation], 200); 
	    	} else {
	    		return response()->json(['message'=>'something went wrong', false], 500);
	    	}
    	} catch (Exception $e) {
    		return $e;
    	}

    }

    public function getHistory(Request $request)
	{
	    $calculation = LoanCalculation::findOrFail($request->id);

	    return response()->json([
	        'emiData' => $calculation,
	    ]);
	}

}
