<x-guest-layout>
	<form method="POST" action="{{ route('password.email') }}" class="mt-5 pt-5">
		@csrf

		<span class="text-uppercase fs-sm-14 text-muted fw-600 mb-4 d-block">{{ __('Forgot your password?') }}</span>
		<h1 class="fs-sm-48 fw-600 mb-4">Recuperar contraseña<span class="text-primary">.</span></h1>

		<div class="row">
			<div class="col-sm-3">
				<div class="mb-4 text-sm">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</div>

				@if (session('status'))
					<div class="bg-success text-white p-3 rounded-4 mb-3">{{ session('status') }}</div>
				@endif

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
			</div>
		</div>

		<button class="btn btn-primary px-5 rounded-4 py-3 fs-sm-18">{{ __('Email Password Reset Link') }}</button>
	</form>
</x-guest-layout>
