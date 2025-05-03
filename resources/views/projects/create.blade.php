@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Create New Project</h2>
    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-secondary">
      <i class="bx bx-arrow-back me-1"></i> Back to Projects
    </a>
  </div>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Project Details</h5>
      <small class="text-muted">Fields marked with <span class="text-danger">*</span> are required</small>
    </div>
    <div class="card-body">
      <form id="projectForm" method="POST" action="{{ route('projects.store') }}">
        @csrf
        
        <div class="row g-3">

          <div class="col-md-12">
            <label for="projectTitle" class="form-label">Project Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="projectTitle" name="title" placeholder="Enter project title" required>
          </div>

          <div class="col-md-6">
            <label for="startDate" class="form-label">Start Date <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bx bx-calendar"></i></span>
              <input type="date" class="form-control" id="startDate" name="start_date" required>
            </div>
          </div>

          <div class="col-md-6">
            <label for="endDate" class="form-label">End Date <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bx bx-calendar"></i></span>
              <input type="date" class="form-control" id="endDate" name="end_date" required>
            </div>
          </div>

          <div class="col-md-6">
            <label for="projectStatus" class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select" id="projectStatus" name="status" required>
              <option value="" disabled selected>Select status</option>
              <option value="pending">Pending</option>
              <option value="in-progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label">Team Members <span class="text-danger">*</span></label>
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center" type="button" id="teamMembersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <span id="selectedMembersText">Select team members</span>
              </button>
              <ul class="dropdown-menu w-100 p-3" aria-labelledby="teamMembersDropdown" style="max-height: 300px; overflow-y: auto;">
                @foreach($members as $member)
                <li class="mb-2">
                  <div class="form-check">
                    <input class="form-check-input member-checkbox" type="checkbox" name="user_ids[]" value="{{ $member->id }}" id="member_{{ $member->id }}">
                    <label class="form-check-label d-flex align-items-center" for="member_{{ $member->id }}">
                      <div>
                        <span class="d-block fw-semibold">{{ $member->name }}</span>
                        <small class="text-muted">{{ $member->email }}</small>
                      </div>
                    </label>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
            <div id="selectedMembersBadges" class="d-flex flex-wrap gap-2 mt-2"></div>
          </div>


          <div class="col-12 mt-4">
            <button type="submit" class="btn btn-primary">
              <i class="bx bx-plus me-1"></i> Create Project
            </button>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>

<style>
  .dropdown-menu {
    min-width: 100%;
  }
  .member-checkbox:checked + label {
    font-weight: 500;
  }
  .dropdown-toggle::after {
    margin-left: auto;
  }
</style>


@endsection