@extends('layouts.contentNavbarLayout')

@section('content')

<div class="container-fluid">
  <h1>Project</h1>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">

        <table class="table table-bordered table-hover">

          <thead class="thead-light">
            <tr>
              <th scope="col">ID</th> 
              <th scope="col">TITLE</th>
              <th scope="col">MEMBERS</th>
              <th scope="col">STATUS</th>
              <th scope="col">START DATE</th>
              <th scope="col">END DATE</th>
            </tr>
          </thead>

          @if($projects->isEmpty())
          <tr>
              <td colspan="6" class="text-center text-danger" role="alert">
                No project assigned
              </td>
          </tr>
           @else
          @foreach($projects as $project)
          <tbody>
            <tr>
              <td>{{$project->id}}</td>
              <td>{{$project->title}}</td>
              <td>{{$project->users->pluck('name')->implode(',')}}</td>
              <td>
                <select class="status-dropdown form-select form-select-sm fw-bold text-center  shadow-sm text-black"  data-project-id="{{ $project->id }}">
                    <option value="pending" class="badge bg-danger" {{ $project->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in-progress" class="badge bg-warning" {{ $project->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" class="badge bg-success" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
              </td>
              <td>{{\carbon\carbon::parse($project->start_date)->format('d-M-Y')}}</td>
              <td>{{\carbon\carbon::parse($project->end_date)->format('d-M-Y')}}</td>
            </tr>
          </tbody>
          @endforeach
          @endif
        </table>

      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
  $(document).ready(function () { 

    $('.status-dropdown').on('change', function() {

      var id = $(this).data('project-id');
      var newStatus = $(this).val();

      alert("are you sure want to update status to " + newStatus);

      $.ajax({
        url: "/project/"+id+"/update-status",
        type: "GET",
        data: { status : newStatus},

        success: function(response) {
          // console.log(response);
        },

        error: function(xhr) {
          console.error(xhr.responseText);
        }
      })
    })
   })
</script>

@endsection