<x-guest-layout>
	<form method="POST" action="{{ route('register') }}" class="mt-5 py-5">
		@csrf

		<span class="text-uppercase fs-sm-14 text-muted fw-600 mb-4 d-block">Comencemos</span>
		<h1 class="fs-sm-48 fw-600 mb-4">Crear una nueva cuenta<span class="text-primary">.</span></h1>
		<p class="text-muted mb-4">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-primary">Acceder</a></p>

		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-lg-8 mb-3">
						<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
							<label class="fs-sm-14 text-muted">Nombre y Apellido<span class="text-danger fs-sm-16">*</span></label><br>
							<input class="border-0 bg-transparent w-100" type="text" name="name" value="{{ old('name') }}" autofocus placeholder="Nombre y Apellido" required />
						</div>

						@error('name')
							<span class="fs-sm-14 text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-lg-4 mb-3">
						<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
							<label class="fs-sm-14 text-muted">F. de nacimiento<span class="text-danger fs-sm-16">*</span></label><br>
							<input type="text" class="border-0 bg-transparent w-100 datetimepicker" name="birthdate" value="{{ old('birthdate') }}" placeholder="F. de nacimiento" required>
						</div>

						@error('birthdate')
							<span class="fs-sm-14 text-danger">{{ $message }}</span>
						@enderror
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 mb-3">
						<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
							<label class="fs-sm-14 text-muted">Dirección<span class="text-danger fs-sm-16">*</span></label><br>
							<input type="text" class="border-0 bg-transparent w-100" name="address" value="{{ old('address') }}" placeholder="Calle y nro." required>
						</div>

						@error('address')
							<span class="fs-sm-14 text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-sm-6 mb-3">
						<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
							<label class="fs-sm-14 text-muted">País<span class="text-danger fs-sm-16">*</span></label><br>
							<input type="text" class="border-0 bg-transparent w-100" name="country" value="{{ old('country') }}" placeholder="País" required>
						</div>

						@error('country')
							<span class="fs-sm-14 text-danger">{{ $message }}</span>
						@enderror
					</div>

					<div class="col-sm-6 mb-3">
						<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
							<label class="fs-sm-14 text-muted">Teléfono<span class="text-danger fs-sm-16">*</span></label><br>
							<input type="number" class="border-0 bg-transparent w-100" name="phone" value="{{ old('phone') }}" placeholder="Teléfono" required>
						</div>

						@error('phone')
							<span class="fs-sm-14 text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-sm-6 mb-3">
						<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
							<label class="fs-sm-14 text-muted">E-mail<span class="text-danger fs-sm-16">*</span></label><br>
							<input type="email" class="border-0 bg-transparent w-100" name="email" value="{{ old('email') }}" placeholder="Email" required>
						</div>

						@error('email')
							<span class="fs-sm-14 text-danger">{{ $message }}</span>
						@enderror
					</div>
				</div>

				<div class="mb-3">
					<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
						<label class="fs-sm-14 text-muted">Profesión / ocupación / oficio<span class="text-danger fs-sm-16">*</span></label><br>
						<input type="text" class="border-0 bg-transparent w-100" name="work" value="{{ old('work') }}" placeholder="Profesión / ocupación / oficio" required>
					</div>

					@error('work')
						<span class="fs-sm-14 text-danger">{{ $message }}</span>
					@enderror
				</div>

				<div class="mb-3">
					<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
						<label class="fs-sm-14 text-muted">Congregación<span class="text-danger fs-sm-16">*</span></label><br>
						<input type="text" class="border-0 bg-transparent w-100" name="church" value="{{ old('church') }}" placeholder="Congregación" required>
					</div>

					@error('church')
						<span class="fs-sm-14 text-danger">{{ $message }}</span>
					@enderror
				</div>

				<div class="row">
					<div class="col-sm-6">
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
					</div>

					<div class="col-sm-6">
						<div class="mb-4">
							<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
								<div class="d-flex align-items-center">
									<div class="flex-fill">
										<label class="fs-sm-14 text-muted">{{ __('Confirm Password') }}</label><br>
										<input id="password_confirmation" class="border-0 bg-transparent w-100" type="password" name="password_confirmation" placeholder="****" required />
									</div>

									<img src="{{ asset('img/icos/ico-pass.svg') }}" width="24" class="opacity-50">
								</div>
							</div>

							@error('password_confirmation')
								<span class="fs-sm-14 text-danger">{{ $message }}</span>
							@enderror
						</div>
					</div>
				</div>
			</div>
		</div>

		@if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
			<div class="form-check text-muted mb-4 fs-sm-14">
				<input class="form-check-input" name="terms" type="checkbox" value="1" id="terms">
				<label class="form-check-label" for="terms">{!! __('I agree to the :terms_of_service and :privacy_policy', ['terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>', 'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',]) !!}</label>

				@error('terms')
					<span class="fs-sm-14 text-danger d-block">{{ $message }}</span>
				@enderror
			</div>
		@endif

		<button class="btn btn-primary px-5 rounded-4 py-3 fs-sm-18">{{ __('Register') }}</button>
	</form>

	@push('scripts')
		<script type="text/javascript">
			flatpickr(".datetimepicker", {
				enableTime: false,
				dateFormat: "d/m/Y",
				defaultDate: '{{ old('birthdate', '01/01/1990')  }}',
				locale: "es",
			});
		</script>
	@endpush
</x-guest-layout>