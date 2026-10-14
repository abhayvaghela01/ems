<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>

{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title') Employee Managemanet System</title>
  <meta name="description" content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

  <!-- Include Styles -->
  @include('layouts/sections/styles')
  
  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts/sections/scriptsIncludes')
</head>

<body>
  {{-- @include('layouts.sections.navbar.navbar') --}}
  {{-- @include('layouts.sections.menu.verticalMenu') --}}
  <!-- Layout Content -->
  

  <!-- Include Scripts -->
  @yield('layoutContent')
  @include('layouts/sections/scripts')
  
  <!--/ Layout Content -->



</body>

</html>
