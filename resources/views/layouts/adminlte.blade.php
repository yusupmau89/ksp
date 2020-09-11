<!DOCTYPE html>
<html>
<head>
  @include('components.head')
  @yield('head-link')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    @include('components.navbar')
    @include('components.main-sidebar')
    @yield('content')
    @include('components.footer')
    @include('components.control-sidebar')
</div>
<!-- ./wrapper -->
@include('components.scripts')
@yield('scripts')
</body>
</html>
