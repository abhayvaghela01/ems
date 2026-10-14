@php
$containerNav = $containerNav ?? 'container-fluid'; 
$navbarDetached = ($navbarDetached ?? '');

@endphp
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->
      @if(isset($navbarFull))
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{url('/')}}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
          <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
        </a>
      </div>
      @endif


      @if(!isset($navbarHideToggle))
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="bx bx-menu bx-sm"></i>
        </a>
      </div>
      @endif

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
          <div class="nav-item d-flex align-items-center">

          </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- Notification -->
          <li class="nav-item dropdown-notifications dropdown ">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <i class="bx bx-bell bx-sm"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge bg-danger rounded-pill adjust badge-notifications">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <div class="dropdown-header">
                        {{ auth()->user()->unreadNotifications->count() ?? 0 }} Notifications
                    </div>
                </li>
                <li><hr class="dropdown-divider"></li>

                @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                <li>

                    <a href="{{ $notification->data['link'] ?? '#' }}" class="dropdown-item mark-as-read" data-id="{{ $notification->id }}">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3" onclick="location.reload();">
                               <i class="{{ $notification->data['icon'] ?? 'bx bx-message-square' }} text-primary" onclick="location.reload();" ></i>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-medium">{{ ucfirst($notification->data['message']) }}</span>
                                <div class="text-muted small mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                @empty
                <li><span class="dropdown-item text-muted">No new notifications</span></li>
                @endforelse
            </ul>
          </li>
          <!--/ Notification -->

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online position-relative">
                <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      @auth
                      <span class="fw-medium d-block">{{auth()->user()->name}}</span>
                      <small class="text-muted"> {{ auth()->user()->getRoleNames()->first() ?? 'No Role Assigned' }}</small>
                      @endauth
                    </div>
                  </div>
                </a>
              </li>
             
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                @auth
                <form method="POST" action="/logout">
                  @csrf

                <button type="submit" class="dropdown-item" href="/logout">
                  <i class='bx bx-power-off me-2'></i>
                  <span class="align-middle">Log Out</span>
                </button>
              </form>

              @else
              <a href="auth/register-basic"  class="dropdown-item" href="/auth/login-basic">
                <i class='bx bx-power-off me-2'></i>
                <span class="align-middle">Register</span>
              </a>
              <a href="auth/login-basic" class="dropdown-item" href="javascript:void(0);">
                <i class='bx bx-power-off me-2'></i>
                <span class="align-middle">Login</span>
              </a>
            @endauth

              </li>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>

      @if(!isset($navbarDetached))
    </div>
    @endif
  </nav>
  <!-- / Navbar -->
  
<div class="mt-2 text-center text-green">
    <x-flash-message />
</div>
<script src="{{asset('assets/js/notification.js')}}"></script>