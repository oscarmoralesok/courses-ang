<x-guest-layout>
	<form method="POST" action="{{ route('login') }}" class="mt-5 pt-5">
		@csrf

		<span class="text-uppercase fs-sm-14 text-muted fw-600 mb-4 d-block">Comencemos</span>
		<h1 class="fs-sm-48 fw-600 mb-4">Iniciar sesión<span class="text-primary">.</span></h1>

		<p class="text-muted mb-4">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-primary">Regístrate</a></p>

		<div class="row mb-4">
			<div class="col-sm-3">
				<div class="row">
					<div class="col-6">
						<a href="{{ url('/login/google') }}" class="btn btn-light w-100"><img src="{{ asset('img/icos/ico-gg.svg') }}" width="16" height="16" class="float-start mt-1"> Google</a>
					</div>
					<div class="col-6">
						<a href="{{ url('/login/facebook') }}" href="#" class="btn btn-primary w-100"><img src="{{ asset('img/icos/ico-fb-w.svg') }}" width="16" height="16" class="float-start mt-1"> Facebook</a>
					</div>
				</div>

				<span class="o d-block mt-4 text-center">ó</span>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3">
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

				<div class="d-flex justify-content-between mb-4 fs-sm-14">
					<div class="form-check text-muted">
						<input class="form-check-input" name="remember" type="checkbox" value="1" id="remember_me">
						<label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
					</div>

					@if (Route::has('password.request'))
						<a class="text-muted" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
					@endif
				</div>
			</div>
		</div>

		<button class="btn btn-primary px-5 rounded-4 py-3 fs-sm-18">{{ __('Log in') }}</button>
	</form>
</x-guest-layout>
