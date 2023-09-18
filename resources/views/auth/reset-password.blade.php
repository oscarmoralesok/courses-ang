<x-guest-layout>
    <form method="POST" action="{{ route('password.update') }}" class="mt-5 pt-5">
        @csrf

        <span class="text-uppercase fs-sm-14 text-muted fw-600 mb-4 d-block">{{ __('Nueva contraseña') }}</span>
        <h1 class="fs-sm-48 fw-600 mb-4">Restablecer contraseña<span class="text-primary">.</span></h1>

        <div class="row">
            <div class="col-sm-3">
                <div class="mb-4 text-sm">Completa los campos para crear una nueva contraseña para tu cuenta.</div>

                <input type="hidden" name="token" value="{{ $request->route('token') }}">


                <div class="mb-4">
                    <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-fill">
                                <label class="fs-sm-14 text-muted">{{ __('Email') }}</label><br>
                                <input id="email" class="border-0 bg-transparent w-100" type="email" name="email" value="{{ old('email', $request -> email) }}" required placeholder="usuario@mail.com" />
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

        <button class="btn btn-primary px-5 rounded-4 py-3 fs-sm-18">{{ __('Reset Password') }}</button>
    </form>
</x-guest-layout>
