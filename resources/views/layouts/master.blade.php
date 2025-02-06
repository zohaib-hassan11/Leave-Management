<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Default Title')</title>

		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
		@stack('styles') <!-- Ensure styles pushed in views appear here -->
	</head>
	<body class="hold-transition sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">
			<!-- Navbar -->
            @include('layouts.header')
			<!-- /.navbar -->

			<!-- Main Sidebar Container -->
			@include('layouts.sidebar')

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
			    @yield('content')
			</div>
			<!-- /.content-wrapper -->

			@include('layouts.footer')
		</div>
		<!-- ./wrapper -->

		<!-- jQuery -->
		<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>

		@stack('scripts') <!-- Ensure scripts pushed in views appear here -->
	</body>
</html>
