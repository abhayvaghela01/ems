@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container-fluid">
  <h1>My Payslip</h1>
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <!-- Toolbar with Search -->
        <div class="d-flex justify-content-between align-items-center mb-3">
       
        </div>

        <!-- Payslip Table -->
        <table id="payslip_table" class="table table-bordered table-hover">
          <thead class="thead-light">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">NAME</th>
              <th scope="col">MONTH</th>
              <th scope="col">BASIC SALARY</th>
              <th scope="col">NET PAY</th>
              <th scope="col">STATUS</th>
            </tr>
          </thead>
          <tbody>
            @if($payslips->isEmpty())
            <tr>
                <td colspan="6" class="text-center text-danger">
                    No payslip created yet.
                </td>
            </tr>
            @else
                @foreach ($payslips as $payslip)
                <tr>
                    <td>{{ $payslip->id }}</td>
                    <td>{{ $payslip->user->name }}</td>
                    <td>{{ $payslip->month }}</td>
                    <td>{{ $payslip->basic_salary }}</td>
                    <td>{{ $payslip->net_pay }}</td>
                    <td>
                        @if($payslip->payment_status == 'Paid')
                        <span class="badge bg-success">{{ $payslip->payment_status }}</span>
                        @else
                        <span class="badge bg-danger">{{ $payslip->payment_status }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
        
        </table>
      </div>

    </div>
  </div>
</div>

<!-- JavaScript for Table Functionality -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Search Functionality
    const searchInput = document.querySelector('.search-input');
    searchInput.addEventListener('input', function () {
      const searchTerm = searchInput.value.toLowerCase();
      const rows = document.querySelectorAll('#payslip_table tbody tr');

      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
      });
    });
  });
</script>
@endsection