<?php

namespace App\Http\Controllers;

use App\Models\Payslip;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class PayslipController extends Controller
{
    //
    public function index(Request $request)
    {
        $payslips = Payslip::with('user')->paginate(5);

        return view('payslips.index', compact('payslips'));
    }

    public function search(Request $request)
    {
        $output = "";
        $search = $request->search;
        $payslips = Payslip::with('User')->where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('month', 'LIKE', '%' . $search . '%')
            ->orWhere('basic_salary', 'LIKE', '%' . $search . '%')
            ->orWhere('net_pay', 'LIKE', '%' . $search . '%')
            ->orWhere('payment_status', 'LIKE', '%' . $search . '%')
            ->orWhereHas('user', function ($q) use ($search) {
                $q->Where('name', 'LIKE', '%' . $search . '%');
            })->get();

        foreach ($payslips as $payslip) {
            $output .=
                ' <tr>
             <td>' . $payslip->id . '</td>
             <td>' . $payslip->user->name . '</td>
             <td>' . $payslip->month . '</td>
             <td>' . $payslip->basic_salary . '</td>
             <td>' . $payslip->net_pay . '</td>
             <td>' . ($payslip->payment_status == 'Paid' ?
                    '<span class="badge bg-success">Paid</span>' :
                    '<span class="badge bg-danger">' . $payslip->payment_status . '</span>') . '</td>
             <td>
                    <div class="d-flex gap-2">
                    <a href=" ' . route('payslips.edit', $payslip->id) . ' ">
                    <button type="button" class="btn btn-warning btn-sm edit-payslip" data-bs-toggle="modal" data-id=" ' . $payslip->id . ' "
                        >
                        <i class="bx bx-edit"></i> Edit
                    </button>
                    </a>
                    <form action=" ' . route('payslips.destroy', $payslip->id) . ' " method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value=" ' . csrf_token() . ' ">
                    <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this payslip? \')">
                        <i class="bx bx-trash"></i> Delete
                        </button>
                    </form>
                    </div>

            </td>
            </tr> ';
        }
        return response($output);
    }

    public function create(Request $request)
    {

        $members = User::whereHas('roles', function ($query) {
            $query->where('role_id', 3);
        })->get();

        return view('payslips.create', compact('members'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'user_id' => 'required|exists:users,id',
            'month' => [
                'required',
                'date_format:Y-m',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = Payslip::where('user_id', $request->user_id)
                        ->where('month', $value)
                        ->exists();

                    if ($exists) {
                        $fail('A payslip for this member already exists.');
                    }
                },
            ],
            'basic_salary' => 'required|numeric|min:0',
            'working_days' => 'required|integer|min:1',
            'loss_of_pay_days' => 'required|integer|min:0',
            'paid_days' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'incentives' => 'nullable|numeric|min:0',
            'leave_deduction' => 'nullable|numeric|min:0',
            'over_time_hours' => 'nullable|integer|min:0',
            'over_time_rate' => 'nullable|numeric|min:0',
            'over_time_payment' => 'nullable|numeric|min:0',
            'net_pay' => 'required|numeric|min:0',
            'payment_status' => 'required|in:Paid,Unpaid',
        ]);

        $user = User::findOrFail($request->user_id);
        if (!$user->hasRole('member')) {
            return redirect()->route('payslips.index')->with('message', 'Payslip can only be created for Members.');
        }

        Payslip::create($formField);

        return redirect()->route('payslips.index')->with('message', 'Payslip created successfully!');
    }
    public function edit(Payslip $payslip)
    {
        $payslip->load('user');
        return view('payslips.edit', compact('payslip'));
    }

    public function update(Request $request, Payslip $payslip)
    {

        $formField = $request->validate([
            'user_id' => 'required|exists:users,id',
            'month' => 'required|date_format:Y-m',
            'basic_salary' => 'required|numeric|min:0',
            'working_days' => 'required|integer|min:1',
            'loss_of_pay_days' => 'required|integer|min:0',
            'paid_days' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'incentives' => 'nullable|numeric|min:0',
            'leave_deduction' => 'nullable|numeric|min:0',
            'over_time_hours' => 'nullable|integer|min:0',
            'over_time_rate' => 'nullable|numeric|min:0',
            'over_time_payment' => 'nullable|numeric|min:0',
            'net_pay' => 'required|numeric|min:0',
            'payment_status' => 'required|in:Paid,Unpaid',
        ]);

        $payslip->update($formField);

        return redirect()->route('payslips.index')->with('message', 'payslip updated successfully!');
    }

    public function destroy(Payslip $payslip)
    {

        $payslip->delete();

        return redirect()->route('payslips.index')->with('message', 'Payslip deleted successfully!');
    }
}
