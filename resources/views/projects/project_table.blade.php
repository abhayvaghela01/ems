<table class="table table-bordered table-hover">

  <thead class="thead-light">
    <tr>
      <th scope="col">ID</th> 
      <th scope="col">TITLE</th>
      <th scope="col">USERS</th>
      <th scope="col">STATUS</th>
      <th scope="col">START DATE</th>
      <th scope="col">END DATE</th>
      <th scope="col">ACTIONS</th>
    </tr>
  </thead>

  @foreach($projects as $project)
  <tbody>
    <tr>
      <td>{{$project->id}}</td>
      <td>{{$project->title}}</td>
      {{-- @dd($project->users()) --}}
      <td>{{$project->users()->pluck('name')->implode(',')}}</td>
      <td>
        <span class="badge bg-{{ $project->status === 'pending' ? 'danger' : ($project->status === 'in-progress' ? 'warning' : 'success') }}">
          {{ ucfirst($project->status) }}
        </span>
      </td>
      <td>{{\carbon\carbon::parse($project->start_date)->format('d-M-Y')}}</td>
      <td>{{\carbon\carbon::parse($project->end_date)->format('d-M-Y')}}</td>
      <td>
        <div class="d-flex gap-2">
          <a href="/projects/{{$project->id}}/edit">
          <button type="button" class="btn btn-warning btn-sm edit-project" data-bs-toggle="modal" data-id="{{$project->id}}" data-title="{{$project->title}}" data-start_date="{{$project->start_date}}" data-end_date="{{$project->end_date}}" data-status="{{$project->status}}"
            >
            <i class="bx bx-edit"></i> Edit
          </button>
        </a>
          <form action="{{route('projects.destroy', $project->id)}}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this project?')">
              <i class="bx bx-trash"></i> Delete
            </button>
          </form>
        </div>
      </td>
    </tr>
  </tbody>
  @endforeach

</table>