@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between">
    <h1>Payslips</h1>
    <a href="/payslips/create">
      <button type="button" class="btn btn-sm btn-primary">
        <i class="bx bx-plus"></i>
      </button>
    </a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center mb-3">

          <div class="input-group w-25">
            <input type="search" id="search" name="search" class="form-control search-input" placeholder="search here" aria-label="Search" >
            <button type="submit" id="searchBtn" class="btn btn-outline-primary">
              <i class="bx bx-search"></i>
            </button>
          </div>

        </div>

        <table id="payslip_table" class="table table-bordered table-hover">

          <thead class="thead-light">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">MEMBER</th>
              <th scope="col">MONTH</th>
              <th scope="col">BASIC SALARY</th>
              <th scope="col">NET PAY</th>
              <th scope="col">STATUS</th>
              <th scope="col">ACTIONS</th>
            </tr>
          </thead>
          
          @if($payslips->isEmpty())
            <tr>
              <td class="text-center text-danger" colspan="7">No payslip found</td>
            </tr>
          @else
          @foreach ($payslips as $payslip)
          <tbody class="allData">
            <tr>
              <td>{{$payslip->id}}</td>
              <td>{{$payslip->user->name}}</td>
              <td>{{$payslip->month}}</td>
              <td>{{$payslip->basic_salary}}</td>
              <td>{{$payslip->net_pay}}</td>
              <td>
                @if($payslip->payment_status == 'Paid')
                <span class="badge bg-success">{{$payslip->payment_status}}</span>
                @else 
                <span class="badge bg-danger">{{$payslip->payment_status}}</span>
                @endif
              </td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route('payslips.edit', $payslip->id) }}">
                  <button type="button" class="btn btn-warning btn-sm edit-payslip" data-bs-toggle="modal" data-id="{{$payslip->id}}"
                    >
                    <i class="bx bx-edit"></i> Edit
                  </button>
                </a>
                  <form action="{{ route('payslips.destroy', $payslip->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this payslip?')">
                      <i class="bx bx-trash"></i> Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          </tbody>
          @endforeach
          @endif
          <tbody id="content" class="searchData"></tbody>

        </table>
        
      </div>
    </div>
  </div>
</div>

@if($payslips->hasPages())
<div class="d-flex justify-content-center mt-4">
  {{ $payslips->links('vendor.pagination.bootstrap-5') }}
</div>
@endif

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

  $(document).ready(function() {

    $('#search').on('keyup', function() {

    $value = $(this).val();
      // alert($value);
    
      if($value) {
        $('.allData').hide();
        $('.searchData').show();
      } else {
        $('.allData').show();
        $('.searchData').hide();
      }

      $.ajax({
        url : "{{ route('payslip.search')}}",
        type: "GET",
        data : {'search': $value},

        success : function (data) 
        {
          // console.log(data);
          $('#content').html(data);
        }
      });

    })
  })

</script>

{{-- <script>
  $(document).ready(function() {

    function SearchInput(SearchTerm) {
        $.ajax({
          url : "{{route('payslips.index')}}",
          method: "GET",
          data : {search : SearchTerm},
          dataType : 'html',
          success: function (response) {
              $('#payslipTableContainer').html(response);
              // console.log(response);
            },
            error : function (xhr) {
              console.error(xhr.responseText);
            }
        })
      }

      $('#searchBtn').click(function() {
        SearchInput($('#search').val());
      })

      $('#search').keypress( function(e) {
        if(e.which === 13) {
          SearchInput($(this).val());
        }
      })

  })
</script> --}}

@endsection