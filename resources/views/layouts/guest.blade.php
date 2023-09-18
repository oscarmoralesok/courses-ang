<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="mh-100 h-100">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

		<!-- Styles -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
		@vite(['resources/css/auth.scss'])
	</head>
	<body class="mh-100 h-100">

		<div class="p-sm-5 p-4 text-dark">

			<div class="row">
				<div class="col-sm-6">
					<div class="d-flex justify-content-between align-items-center">
						<a href="{{ url('/') }}"><img src="{{ asset('img/logo.svg') }}" width="40"></a>

						<nav>
							@if ( ! request() -> is('login') )
								<a href="{{ route('login') }}" class="text-muted ms-sm-5 ms-2">Iniciar sesión</a>
							@endif
							@if ( ! request() -> is('register') )
								<a href="{{ route('register') }}" class="text-muted ms-sm-5 ms-2">Registrarse</a>
							@endif
						</nav>
					</div>
				</div>
			</div>

			<div class="px-sm-5 px-3">{{ $slot }}</div>

		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
		<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
		@vite(['resources/js/app.js'])

		@stack('scripts')
	</body>
</html>
