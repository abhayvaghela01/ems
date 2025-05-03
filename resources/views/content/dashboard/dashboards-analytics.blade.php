@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')

<div class="row">
  <div class=" mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            @auth
            <h5 class="card-title text-primary">Hi {{ auth()->user()->name }}</h5>
            <p class="mb-4">Welcome to your Dashboard</p>
        @else
            <h5 class="card-title text-primary">Hi User</h5>
            <p class="mb-4">Please <a href="/auth/login-basic">login</a>  or <a href="/auth/register-basic">register</a> </p>
        @endauth
        
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="{{asset('assets/img/illustrations/man-with-laptop-light.png')}}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-3">
  @if(auth()->user()->hasRole(['admin','hr']))
  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body d-flex align-items-start justify-content-between">
        <div>
          <h6 class="mt-1">Total Users</h6>
          <h3 class="fw-bold my-2">{{ $totalUsers }}</h3>
          <a href="/users" class="text-decoration-none text-warning">
            <small>
              <i class="bx bx-right-arrow-alt"></i>
              View more
            </small>
          </a>
        </div>
        <div class="avatar">
          <span class="avatar-initial bg-label-warning rounded">
            <i class="icon-base bx-sm bx bxs-user-detail text-warning"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  @endauth

  @if(auth()->user()->hasRole(['admin','hr']))
  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body d-flex align-items-start justify-content-between">
        <div>
          <h6 class="mt-1">Total Projects</h6>
          <h3 class="fw-bold my-2">{{ $totalProjects }}</h3>
          <a href="/projects" class="text-decoration-none text-warning">
            <small>
              <i class="bx bx-right-arrow-alt"></i>
              View more
            </small>
          </a>
        </div>
        <div class="avatar">
          <span class="avatar-initial bg-label-warning rounded">
            <i class="menu-icon tf-icons bx bx-briefcase-alt-2 text-purple text-dark"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  @endauth

  @if(auth()->user()->hasRole('member'))
  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body d-flex align-items-start justify-content-between">
        <div>
          <h6 class="mt-1">Assigned Projects</h6>
          <h3 class="fw-bold my-2">{{ $assignedProjects }}</h3>
          <a href="/project" class="text-decoration-none text-warning">
            <small>
              <i class="bx bx-right-arrow-alt"></i>
              View more
            </small>
          </a>
        </div>
        <div class="avatar">
          <span class="avatar-initial bg-label-warning rounded">
            <i class="menu-icon tf-icons bx bx-briefcase-alt-2 text-purple text-dark"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  @endauth

  @if(auth()->user()->hasRole(['admin','hr']))
  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body d-flex align-items-start justify-content-between">
        <div>
          <h6 class="mt-1">Total Payslips</h6>
          <h3 class="fw-bold my-2">{{$totalPayslips}}</h3>
          <a href="/payslips" class="text-decoration-none text-warning">
            <small>
              <i class="bx bx-right-arrow-alt"></i>
              View more
            </small>
          </a>
        </div>
        <div class="avatar">
          <span class="avatar-initial bg-label-info rounded">
            <i class="icon-base bx-sm bx bx-file text-info"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
 @endif

 
  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body d-flex align-items-start justify-content-between">
        <div>
          <h6 class="mt-1">Total Todos</h6>
          <h3 class="fw-bold my-2">{{ $totalTodos }}</h3>
          <a href="/todos" class="text-decoration-none text-warning">
            <small>
              <i class="bx bx-right-arrow-alt"></i>
              View more
            </small>
          </a>
        </div>
        <div class="avatar">
          <span class="avatar-initial bg-label-success rounded">
            <i class="imenu-icon tf-icons bx bx-task text-success"></i>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body d-flex align-items-start justify-content-between">
        <div>
          <h6 class="mt-1">Total Notes</h6>
          <h3 class="fw-bold my-2">{{ $totalNotes }}</h3>
          <a href="/notes" class="text-decoration-none text-warning">
            <small>
              <i class="bx bx-right-arrow-alt"></i>
              View more
            </small>
          </a>
        </div>
        <div class="avatar">
          <span class="avatar-initial bg-label-primary rounded">
            <i class="icon-base bx-sm bx bx-note text-primary"></i>
          </span>
        </div>
      </div>
    </div>
  </div>

  

</div>

@endsection
