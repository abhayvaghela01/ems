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
      <form action="{{ route('payslips.store') }}" method="POST">
        @csrf

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
            <label for="user_id" class="form-label">Select User <span class="text-danger">*</span></label>
            <select class="form-select" id="user_id" name="user_id" required>
              <option value="" disabled selected>Select User</option>
              @foreach($members as $member)
               <option value="{{ $member->id }}">{{ $member->name }}</option>
              @endforeach
            </select>
          </div>


          <div class="mb-3 col-md-4">
            <label for="month" class="form-label">Payslip Month <span class="text-danger">*</span></label>
            <input type="month" class="form-control" id="month" name="month" required>
          </div>


          <div class="mb-3 col-md-4">
            <label for="basic_salary" class="form-label">Basic Salary <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="basic_salary" name="basic_salary" step="0.01" required>
            </div>
          </div>


          <div class="mb-3 col-md-4">
            <label for="working_days" class="form-label">Working Days <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="working_days" name="working_days" required>
          </div>


          <div class="mb-3 col-md-4">
            <label for="loss_of_pay_days" class="form-label">Loss of Pay Days <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="loss_of_pay_days" name="loss_of_pay_days" required>
          </div>


          <div class="mb-3 col-md-4">
            <label for="paid_days" class="form-label">Paid Days</label>
            <input type="number" class="form-control" id="paid_days" name="paid_days" readonly>
          </div>


          <div class="mb-3 col-md-4">
            <label for="bonus" class="form-label">Bonus</label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="bonus" name="bonus" step="0.01">
            </div>
          </div>


          <div class="mb-3 col-md-4">
            <label for="incentives" class="form-label">Incentives</label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="incentives" name="incentives" step="0.01">
            </div>
          </div>


          <div class="mb-3 col-md-4">
            <label for="leave_deduction" class="form-label">Leave Deduction</label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="leave_deduction" name="leave_deduction" readonly>
            </div>
          </div>


          <div class="mb-3 col-md-4">
            <label for="over_time_hours" class="form-label">Over Time Hours</label>
            <input type="number" class="form-control" id="over_time_hours" name="over_time_hours">
          </div>


          <div class="mb-3 col-md-4">
            <label for="over_time_rate" class="form-label">Over Time Rate <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="over_time_rate" name="over_time_rate" step="0.01" required>
            </div>
          </div>


          <div class="mb-3 col-md-4">
            <label for="over_time_payment" class="form-label">Over Time Payment</label>
            <div class="input-group">
              <span class="input-group-text">$</span>
              <input type="number" class="form-control" id="over_time_payment" name="over_time_payment" readonly>
            </div>
          </div>

          <div class="mb-3 col-md-4">
            <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
            <select class="form-select" id="payment_status" name="payment_status" required>
              <option value="Paid">Paid</option>
              <option value="Unpaid">Unpaid</option>
            </select>
          </div>

          <input type="hidden" id="net_pay" name="net_pay" value="0.00">

          <div class="mb-3 col-md-12 text-end">
            <h6>
              Net Payable ($): <span id="net_payable">0.00</span>
            </h6>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Create Payslip</button>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Function to calculate Paid Days and Leave Deduction
    function calculatePaidDaysAndDeduction() {
        const workingDays = parseFloat($('#working_days').val()) || 0;
        const lossOfPayDays = parseFloat($('#loss_of_pay_days').val()) || 0;
        const basicSalary = parseFloat($('#basic_salary').val()) || 0;

        // Calculate Paid Days
        const paidDays = workingDays - lossOfPayDays;
        $('#paid_days').val(paidDays.toFixed(2));

        // Calculate Leave Deduction
        const dailySalary = basicSalary / workingDays;
        const leaveDeduction = dailySalary * lossOfPayDays;
        $('#leave_deduction').val(leaveDeduction.toFixed(2));
    }

    // Function to calculate Over Time Payment
    function calculateOverTimePayment() {
        const overTimeHours = parseFloat($('#over_time_hours').val()) || 0;
        const overTimeRate = parseFloat($('#over_time_rate').val()) || 0;

        // Calculate Over Time Payment
        const overTimePayment = overTimeHours * overTimeRate;
        $('#over_time_payment').val(overTimePayment.toFixed(2));
    }

    // Function to calculate Net Payable
    function calculateNetPayable() {
        const basicSalary = parseFloat($('#basic_salary').val()) || 0;
        const bonus = parseFloat($('#bonus').val()) || 0;
        const incentives = parseFloat($('#incentives').val()) || 0;
        const leaveDeduction = parseFloat($('#leave_deduction').val()) || 0;
        const overTimePayment = parseFloat($('#over_time_payment').val()) || 0;

        // Calculate Net Payable
        const netPayable = basicSalary + bonus + incentives - leaveDeduction + overTimePayment;
        $('#net_payable').text(netPayable.toFixed(2));
        $('#net_pay').val(netPayable.toFixed(2)); 
    }

    // Attach Event Listeners
    $('#working_days, #loss_of_pay_days, #basic_salary').on('input', function () {
        calculatePaidDaysAndDeduction();
        calculateNetPayable();
    });

    $('#over_time_hours, #over_time_rate').on('input', function () {
        calculateOverTimePayment();
        calculateNetPayable();
    });

    $('#bonus, #incentives').on('input', function () {
        calculateNetPayable();
    });
});
</script>
@endsection