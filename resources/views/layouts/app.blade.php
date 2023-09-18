<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }} {{ $titlePage ?? '' }}</title>

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

		<!-- Styles -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

		@vite(['resources/css/app.scss'])

		<!-- Styles -->
		@livewireStyles
	</head>

	<body>

		@if ( Auth::user() -> role == 2 )
			<script type="text/javascript">
				window.location.href="{{ route('panel.dashboard') }}";
			</script>
		@endif

		@include('partials.admin.nav')

		<main>
			<div class="container-fluid p-4">
				<div class="d-flex justify-content-end">
					<div class="dropdown">
						<button class="border-0 bg-transparent p-0 m-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							@if ( Auth::user() -> profile_photo_path ) 
								@php
									$photo = asset(Auth::user() -> profile_photo_path);
								@endphp
							@elseif ( Auth::user() -> socialProfiles -> count() )
								@php
									$photo = Auth::user() -> socialProfiles -> first() -> social_avatar;
								@endphp
							@else
								@php
									$photo = Auth::user() -> profile_photo_url;
								@endphp
							@endif

							<img class="rounded-4" width="50" height="50" src="{{ $photo }}" alt="{{ Auth::user()->name }}" />
						</button>
						<ul class="dropdown-menu dropdown-menu-end border-0 shadow">
							@if ( Auth::user() -> role == 1 )
								<li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Administrador</a></li>
							@endif
							<li><a class="dropdown-item" href="{{ route('admin.profile') }}">Perfil</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" onclick="event.preventDefault(); $('form.logout').submit();" href="{{ route('logout') }}">Cerrar sesión</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class=" {{ (request()->is('admin/profesores*') || request()->is('admin/curso/*') || request()->is('admin/usuarios*') ) ? 'container-fluid ps-0' : 'container' }} pb-4">
				{{ $slot }}
			</div>
		</main>

		<form method="POST" class="logout" action="{{ route('logout') }}" x-data>
			@csrf
		</form>

		@stack('modals')

		{{-- TOASTs --}}
		<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
			<div id="liveToastSaved" class="toast bg-success text-white rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex justify-content-between align-items-center pe-2">
					<div class="toast-body">Guardado correctamente</div>
					<button type="button" class="btn-close f-invert" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>

			<div id="liveToastUpdated" class="toast bg-primary text-white rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex justify-content-between align-items-center pe-2">
					<div class="toast-body">Actualizado correctamente</div>
					<button type="button" class="btn-close f-invert" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>

			<div id="liveToastDeleted" class="toast bg-danger text-white rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex justify-content-between align-items-center pe-2">
					<div class="toast-body">Eliminado correctamente</div>
					<button type="button" class="btn-close f-invert" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>

			{{ $toast ?? '' }}
		</div>

		@livewireScripts

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/es.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
		<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

		<script type="text/javascript">
			window.livewire.on('saved', () => {
				$('.offcanvas').offcanvas('hide');
				$('.modal').modal('hide');
				var toast = new bootstrap.Toast(document.getElementById('liveToastSaved'))
				toast.show()
			})
			window.livewire.on('updated', () => {
				$('.offcanvas').offcanvas('hide');
				$('.modal').modal('hide');
				var toast = new bootstrap.Toast(document.getElementById('liveToastUpdated'))
				toast.show()
			})
			window.livewire.on('deleted', () => {
				$('.offcanvas').offcanvas('hide');
				$('.modal').modal('hide');
				var toast = new bootstrap.Toast(document.getElementById('liveToastDeleted'))
				toast.show()
			})
			window.livewire.on('deletedNoClose', () => {
				var toast = new bootstrap.Toast(document.getElementById('liveToastDeleted'))
				toast.show()
			})
		</script>

		@vite(['resources/js/app.js'])
		@stack('scripts')
	</body>
</html>
