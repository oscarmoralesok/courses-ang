<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }} {{ $titlePage ?? '' }}</title>

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

		<!-- Styles -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

		@vite(['resources/css/web.scss'])

		<!-- Styles -->
		@livewireStyles
	</head>

	<body>
		<header class="py-4 position-absolute w-100 start-0 top-0">
			<div class="container">
				<div class="justify-content-between align-items-center d-none d-md-flex">
					<a href="{{ url('/') }}" class="text-dark fs-sm-21 text-uppercase d-flex align-items-center fw-700">ANG Courses</a>

					<nav class="fs-sm-14">
						<a class="text-dark" href="{{ config('app.url') }}/#about">Acerca de</a>
						<a class="text-dark mx-4" href="{{ config('app.url') }}/#courses">Cursos</a>
						<a class="text-dark" href="{{ config('app.url') }}/#contacto">Contacto</a>
					</nav>

					<div>
						<div class="form-control border-dark rounded-3">
							<input class="border-0" type="text" name="s" style="width: 300px" placeholder="Buscar curso...">
							<img src="{{ asset('img/icos/ico-search-3.svg') }}" width="16">
						</div>
					</div>

					<div>
						@auth()
							<a href="{{ route('panel.dashboard') }}" class="btn btn-primary py-2 px-3 me-2 fs-sm-13 text-uppercase fw-600">Panel de control</a>
						@else
							<a href="{{ route('login') }}" class="btn btn-light py-2 px-3 me-2 fs-sm-13 text-uppercase fw-600">Acceder</a>
							<a href="{{ route('register') }}" class="btn btn-dark border-0 py-2 px-3 text-uppercase fs-sm-13 fw-600">Registrarse</a>
						@endauth
					</div>
				</div>

				<div class="justify-content-between align-items-center d-flex d-md-none header-mobile px-3">
					<a href="{{ url('/') }}" class="text-dark fs-sm-21 text-uppercase d-flex align-items-center fw-700">ANG Courses</a>

					<div class="d-flex">
						@auth()
							<a href="{{ route('panel.dashboard') }}" class="btn btn-primary py-2 px-3 me-2 fs-sm-13 text-uppercase fw-600">Panel de control</a>
						@else
							<a href="{{ route('register') }}" class="btn btn-dark border-0 py-2 px-3 text-uppercase fs-sm-13 fw-600">Registrarse</a>
						@endauth

						<button class="btn bg-dark ms-3" onclick="$('.nav-mobile').toggleClass('active')">
							<span class="bg-white d-block mb-1"></span>
							<span class="bg-white d-block mb-1"></span>
							<span class="bg-white d-block"></span>
						</button>
					</div>


					<div class="position-fixed h-100 bg-white top-0 shadow nav-mobile p-4">
						<div class="d-flex align-items-center justify-content-between mb-4">
							<h3 class="text-uppercase fs-sm-18 fw-600">Menú</h3>

							<a class="text-dark fs-sm-24 fw-600" onclick="$('.nav-mobile').toggleClass('active')">&times;</a>
						</div>

						<nav class="fs-sm-14 pb-4">
							<a class="text-dark d-block mb-3 fs-sm-18" href="{{ config('app.url') }}/#about">Acerca de</a>
							<a class="text-dark d-block mb-3 fs-sm-18" href="{{ config('app.url') }}/#courses">Cursos</a>
							<a class="text-dark d-block mb-3 fs-sm-18" href="{{ config('app.url') }}/#contacto">Contacto</a>
						</nav>

						<a href="{{ route('login') }}" class="btn btn-light py-2 px-3 me-2 fs-sm-13 text-uppercase fw-600">Acceder</a>
						<a href="{{ route('register') }}" class="btn btn-dark border-0 py-2 px-3 text-uppercase fs-sm-13 fw-600">Registrarse</a>

						<div class="mt-4">
							<div class="form-control border-dark rounded-3 d-flex overflow-hidden">
								<input class="border-0" type="text" name="s" placeholder="Buscar curso...">
								<img src="{{ asset('img/icos/ico-search-3.svg') }}" width="16">
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		{{ $slot }}

		<footer class="bg-black py-5">
			<div class="container py-4">
				<div class="px-3 px-sm-0">
					<div class="row justify-content-between">
						<div class="col-sm-4 mb-5 mb-sm-0">
							<span class="text-white fs-sm-21 text-uppercase fw-700 mb-3 d-inline-block">ANG Courses</span>
							<p class="fs-sm-12 text-white opacity-50 mb-5">Somos una plataforma pensada para brindar herramientas de crecimiento y conocimiento para todos aquellos que anhelen seguir perfeccionándose en diferentes áreas como ministerio, relaciones familiares, administración de recursos, dones, etc. Manteniendo un enfoque Cristocéntrico y práctico. </p>
							<a href="#" target="_blank"><img src="{{ asset('img/web/ico-ig-2.svg') }}" width="24" height="24" class="me-3"></a>
							<a href="#" target="_blank"><img src="{{ asset('img/web/ico-fb-2.svg') }}" width="24" height="24" class="me-3"></a>
							<a href="#" target="_blank"><img src="{{ asset('img/web/ico-msn-2.svg') }}" width="24" height="24" class="me-3"></a>
						</div>
						<div class="col-sm-7">
							<div class="row fs-sm-13">
								<div class="col-sm-6 mb-5 mb-sm-0">
									<h4 class="fs-sm-14 text-white fw-600 mb-4">Enlaces</h4>
									<ul class="list-unstyled opacity-50">
										<li class="mb-3"><a class="text-white" href="{{ config('app.url') }}">Home</a></li>
										<li class="mb-3"><a class="text-white" href="{{ config('app.url') }}/#about">Acerca de</a></li>
										<li class="mb-3"><a class="text-white" href="{{ config('app.url') }}/#courses">Cursos</a></li>
										<li><a class="text-white" href="{{ config('app.url') }}/#contacto">Contacto</a></li>
									</ul>
								</div>
								<div class="col-sm-6">
									<h4 class="fs-sm-14 text-white fw-600 mb-4">Legal</h4>
									<ul class="list-unstyled opacity-50">
										<li class="mb-3"><a class="text-white" href="#">Términos y condiciones</a></li>
										<li class="mb-3"><a class="text-white" href="#">Política de privacidad</a></li>
										<li class="mb-3"><a class="text-white" href="#">Política de devolución</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>

		<form method="POST" class="logout" action="{{ route('logout') }}" x-data>@csrf</form>

		@auth()
		@else
			<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header border-0 pt-4 pb-0 px-4 mb-4 align-items-center">
							<h1 class="fs-sm-18 fw-600 m-0">Iniciar sesión</h1>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body px-4 pb-4">
							<form method="POST" action="{{ route('login') }}">
        						@csrf
								<div class="row">
									<div class="col-sm-6">
										<a href="{{ url('/login/google') }}" class="btn btn-light w-100"><img src="{{ asset('img/icos/ico-gg.svg') }}" width="16" height="16" class="float-start mt-1"> Google</a>
									</div>
									<div class="col-sm-6">
										<a href="{{ url('/login/facebook') }}" href="#" class="btn btn-primary w-100"><img src="{{ asset('img/icos/ico-fb-w.svg') }}" width="16" height="16" class="float-start mt-1"> Facebook</a>
									</div>
								</div>

								<span class="o d-block my-4 text-center">ó</span>

								<div class="mb-4">
									<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
										<div class="d-flex align-items-center">
											<div class="flex-fill">
												<label class="fs-sm-14 text-muted">{{ __('Email') }}</label><br>
												<input id="email" class="border-0 bg-transparent w-100" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="usuario@mail.com" />
											</div>

											<img src="{{ asset('img/icos/ico-email.svg') }}" width="24" class="opacity-50">
										</div>
									</div>

									@error('email')
										<span class="fs-sm-14 text-danger">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-4">
									<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
										<div class="d-flex align-items-center">
											<div class="flex-fill">
												<label class="fs-sm-14 text-muted">{{ __('Password') }}</label><br>
												<input id="password" class="border-0 bg-transparent w-100" type="password" name="password" placeholder="****" required />
											</div>

											<img src="{{ asset('img/icos/ico-pass.svg') }}" width="24" class="opacity-50">
										</div>
									</div>

									@error('password')
										<span class="fs-sm-14 text-danger">{{ $message }}</span>
									@enderror
								</div>

								<div class="d-sm-flex justify-content-between mb-4 fs-sm-14">
									<div class="form-check text-muted">
										<input class="form-check-input" name="remember" type="checkbox" value="1" id="remember_me">
										<label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
									</div>

									@if (Route::has('password.request'))
										<a class="text-muted" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
									@endif
								</div>

								<button class="btn btn-primary py-3 rounded-4 w-100" type="submit">{{ __('Login') }}</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		@endauth

		@stack('modals')

		@livewireScripts

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
		<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

		@vite(['resources/js/web.js'])
		@stack('scripts')
	</body>
</html>