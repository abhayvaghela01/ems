@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-end">
    <a href="/payslips">
      <button type="button" class="btn btn-sm btn-primary mb-2">
        <i class="bx bx-list-ul"></i>
      </button>
    </a>
  </div>
  <div class="card shadow-sm">
    <div class="card-body">
      <form action="{{ route('payslips.update', $payslip->id) }}" id="editPayslipForm" method="POST">
        @csrf
        @method('PUT')
        @if ($errors->any())
         <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
          </div>
       @endif

        <div class="row">

          <div class="mb-3 col-md-4">
            <label for="user_name" class="form-label">User</label>
            <input type="text" class="form-control" id="editUsername" readonly disabled name="" value="{{$payslip->user->name}}" readonly>
            <input type="hidden" name="user_id" value="{{$payslip->user->id}}">
          </div>


          <div class="mb-3 col-md-4">
            <label for="month" class="form-label">Payslip Month <span class="text-danger">*</span></label>
            <input type="month" class="form-control" id="editMonth" name="month" value="{{$payslip->month}}" required>
          </div>

 
          <div class="mb-3 col-md-4">
            <label for="basic_salary" class="form-label">Basic Salary <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="editBasic_salary" name="basic_salary" step="0.01" value="{{$payslip->basic_salary}}" required>
            </div>
          </div>

          <div class="mb-3 col-md-4">
            <label for="working_days" class="form-label">Working Days <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="editWorking_days" name="working_days" value="{{$payslip->working_days}}" required>
          </div>

          <div class="mb-3 col-md-4">
            <label for="loss_of_pay_days" class="form-label">Loss of Pay Days <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="editLoss_of_pay_days" name="loss_of_pay_days" value="{{$payslip->loss_of_pay_days}}" required>
          </div>

          <div class="mb-3 col-md-4">
            <label for="paid_days" class="form-label">Paid Days</label>
            <input type="number" class="form-control" id="editPaid_days" name="paid_days" value="{{$payslip->paid_days}}" readonly>
          </div>

       
          <div class="mb-3 col-md-4">
            <label for="bonus" class="form-label">Bonus</label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="editBonus" name="bonus" value="{{$payslip->bonus}}" step="0.01">
            </div>
          </div>

      
          <div class="mb-3 col-md-4">
            <label for="incentives" class="form-label">Incentives</label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="editIncentives" name="incentives" value="{{$payslip->incentives}}" step="0.01">
            </div>
          </div>

          <div class="mb-3 col-md-4">
            <label for="leave_deduction" class="form-label">Leave Deduction</label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="editLeave_deduction" name="leave_deduction" value="{{$payslip->leave_deduction}}" readonly>
            </div>
          </div>

   
          <div class="mb-3 col-md-4">
            <label for="over_time_hours" class="form-label">Over Time Hours</label>
            <input type="number" class="form-control" id="editOver_time_hours" name="over_time_hours" value="{{$payslip->over_time_hours}}">
          </div>

       
          <div class="mb-3 col-md-4">
            <label for="over_time_rate" class="form-label">Over Time Rate</label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="editOver_time_rate" name="over_time_rate" step="0.01" value="{{$payslip->over_time_rate}}" required>
            </div>
          </div>

     
          <div class="mb-3 col-md-4">
            <label for="over_time_payment" class="form-label">Over Time Payment</label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="editOver_time_payment" name="over_time_payment" value="{{$payslip->over_time_payment}}" readonly>
            </div>
          </div>

      
          <div class="mb-3 col-md-4">
            <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
            <select class="form-select" id="editPayment_status" name="payment_status"  required>
              <option value="Paid" {{$payslip->payment_status == 'Paid' ? 'selected' : ''}} >Paid</option>
              <option value="Unpaid" {{$payslip->payment_status == 'Unpaid' ? 'selected' : ''}}>Unpaid</option>
            </select>
          </div>

          <input type="hidden" id="editNet_pay" name="net_pay" value="0.00">

         
          <div class="mb-3 col-md-12 text-end">
            <h6>
              Net Payable ($): <span id="editNet_payable">{{$payslip->net_pay}}</span>
            </h6>
          </div>
        </div>

   
        <button type="submit" class="btn btn-primary">Update Payslip</button>
      </form>
    
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('assets/js/payslipEdit.js')}}"> </script>
<script>
$(document).ready(function () {
 
    function calculatePaidDaysAndDeduction() {
        const workingDays = parseFloat($('#editWorking_days').val()) || 0;
        const lossOfPayDays = parseFloat($('#editLoss_of_pay_days').val()) || 0;
        const basicSalary = parseFloat($('#editBasic_salary').val()) || 0;

        // Calculate Paid Days
        const paidDays = workingDays - lossOfPayDays;
        $('#editPaid_days').val(paidDays.toFixed(2));

        // Calculate Leave Deduction
        const dailySalary = basicSalary / workingDays;
        const leaveDeduction = dailySalary * lossOfPayDays;
        $('#editLeave_deduction').val(leaveDeduction.toFixed(2));
    }

   
    function calculateOverTimePayment() {
        const overTimeHours = parseFloat($('#editOver_time_hours').val()) || 0;
        const overTimeRate = parseFloat($('#editOver_time_rate').val()) || 0;

        // Calculate Over Time Payment
        const overTimePayment = overTimeHours * overTimeRate;
        $('#editOver_time_payment').val(overTimePayment.toFixed(2));
    }


    function calculateNetPayable() {
        const basicSalary = parseFloat($('#editBasic_salary').val()) || 0;
        const bonus = parseFloat($('#editBonus').val()) || 0;
        const incentives = parseFloat($('#editIncentives').val()) || 0;
        const leaveDeduction = parseFloat($('#editLeave_deduction').val()) || 0;
        const overTimePayment = parseFloat($('#editOver_time_payment').val()) || 0;

     
        const netPayable = basicSalary + bonus + incentives - leaveDeduction + overTimePayment;
        $('#editNet_payable').text(netPayable.toFixed(2));
        $('#editNet_pay').val(netPayable.toFixed(2)); 
    }

    // Attach Event Listeners
    $('#editWorking_days, #editLoss_of_pay_days, #editBasic_salary').on('input', function () {
        calculatePaidDaysAndDeduction();
        calculateNetPayable();
    });

    $('#editOver_time_hours, #editOver_time_rate').on('input', function () {
        calculateOverTimePayment();
        calculateNetPayable();
    });

    $('#editBonus, #editIncentives').on('input', function () {
        calculateNetPayable();
    });
});
</script>
@endsection