@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          {{-- <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
              <span class="app-brand-text demo text-body fw-bold">{{config('variables.templateName')}}</span>
            </a>
          </div> --}}
          <!-- /Logo -->
          <h2 class="mb-2 text-center">Login</h2>
          <p class="mb-4">Please sign-in to your account</p>

          <form id="formAuthentication" class="mb-3" action="{{url('auth/login-basic')}}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus value="{{old('email')}}" autocomplete="email">
              @error('email')
              <p class="alert alert-danger text-red-500 text-xs mt-1">{{$message}}</p>
              @enderror
            </div>

            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                {{-- <a href="{{url('auth/forgot-password-basic')}}">
                  <small>Forgot Password?</small>
                </a> --}}
              </div>

              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" autocomplete="current-password" value="{{old('password')}}"/>
                @error('password')
                <p class="alert alert-danger text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
                <span class="input-group-text cursor-pointer"></span>
              </div>
            </div>

            {{-- <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">
                  Remember Me
                </label>
              </div>
            </div> --}}
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
          </form>

          <p class="text-center">
            <span>Don't have account?</span>
            <a href="{{url('auth/register-basic')}}">
              <span>Register here</span>
            </a>
          </p>

        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection
