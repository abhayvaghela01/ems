<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'month',
        'basic_salary',
        'working_days',
        'loss_of_pay_days',
        'paid_days',
        'bonus',
        'incentives',
        'leave_deduction',
        'over_time_hours',
        'over_time_rate',
        'over_time_payment',
        'net_pay',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // public function scopeFilter($query, array $filter)
    // {
    //     if ($filter['search'] ?? false) {
    //         $search = request('search');
    //         $query->where('id', 'like', '%' . $search . '%')
    //             ->orwhere('month', 'like', '%' . $search . '%')
    //             ->orwhere('basic_salary', 'like', '%' . $search . '%')
    //             ->orwhere('net_pay', 'like', '%' . $search . '%')
    //             ->orwhere('payment_status', 'like', '%' . $search . '%')
    //             ->orWhereHas('user', function ($q) use ($search) {
    //                 $q->Where('name', 'like', '%' . $search . '%');
    //             });
    //     }
    // }
}
