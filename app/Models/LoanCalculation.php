<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanCalculation extends Model
{
    use HasFactory;
    protected $table = 'emi_calculations';
    protected $fillable = ['principal_amount', 'interest_rate', 'duration'];

}
