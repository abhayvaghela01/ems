@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between">
    <h1>Projects</h1>
    <a href="/projects/create">
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
            <select class="form-select" id="filter_status" name="status" >
              <option value="" disabled selected>Select status</option>
              <option value="pending">Pending</option>
              <option value="in-progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>
          </div>

        </div>

        <div id="project_table">
         @include('projects.project_table')
        </div>
        
      </div>
    </div>
  </div>
</div>

@if($projects->hasPages())
<div class="d-flex justify-content-center mt-4">
  {{ $projects->links('vendor.pagination.bootstrap-5') }}
</div>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

  $(document).ready(function() {

    $('#filter_status').on('change',function() {

       var status = $(this).val();
      $.ajax({
        url: "{{ route('projects.filter') }}",
        type:"GET",
        data : {status : status},

        success: function(response) {

          // console.log(response);
          $('#project_table').html(response);
        },

        error : function (xhr) {
              console.error(xhr.responseText);
            }
      })
    })
  })

</script>
@endsection