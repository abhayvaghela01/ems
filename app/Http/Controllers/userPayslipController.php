<?php

namespace App\Http\Controllers;

use App\Models\Payslip;
use Illuminate\Http\Request;

class userPayslipController extends Controller
{
    public function index()
    {
        $query = Payslip::with('user');

        // Restrict members to view only their own payslips
        if (auth()->user()->hasRole('member')) {
            $query->where('user_id', auth()->user()->id);
        }
        $payslips = $query->get();

        return view('userPayslip.index', compact('payslips'));
    }
}
