<div class="row mb-5">
    <div class="col-sm-3">
        <h3 class="fs-sm-18">{{ __('Two Factor Authentication') }}</h3>
        <p>{{ __('Add additional security to your account using two factor authentication.') }}</p>
    </div>
    <div class="col-sm-9">
        <div class="shadow rounded-4">
            <div class="p-4">
                <h3 class="fs-sm-18 fw-700">
                    @if ($this->enabled)
                        @if ($showingConfirmation)
                            {{ __('Finish enabling two factor authentication.') }}
                        @else
                            {{ __('You have enabled two factor authentication.') }}
                        @endif
                    @else
                        {{ __('You have not enabled two factor authentication.') }}
                    @endif
                </h3>
                <p class="text-muted">{{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}</p>

                @if ($this->enabled)
                    @if ($showingQrCode)
                        <div class="mt-4 max-w-xl text-sm text-gray-600">
                            <p class="font-semibold">
                                @if ($showingConfirmation)
                                    {{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                                @else
                                    {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application or enter the setup key.') }}
                                @endif
                            </p>
                        </div>

                        <div class="mt-4">
                            {!! $this->user->twoFactorQrCodeSvg() !!}
                        </div>

                        <div class="mt-4 max-w-xl text-sm text-gray-600">
                            <p class="font-semibold">
                                {{ __('Setup Key') }}: {{ decrypt($this->user->two_factor_secret) }}
                            </p>
                        </div>

                        @if ($showingConfirmation)
                            <div class="mb-3">
                                <label>{{ __('Code') }}</label>

                                <div class="row">
                                    <div class="col-md-3">
                                        <input class="form-control" id="code" type="text" name="code" inputmode="numeric" autofocus autocomplete="one-time-code" wire:model.defer="code" wire:keydown.enter="confirmTwoFactorAuthentication" />
                                    </div>
                                </div>

                                @error('code')
                                    <span class="text-danger fs-sm-14">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    @endif

                    @if ($showingRecoveryCodes)
                        <p class="fw-600">{{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}</p>

                        <div class="mb-4">
                            @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                                <div class="font-monospace">{{ $code }}</div>
                            @endforeach
                        </div>
                    @endif
                @endif

                <div>
                    @if (! $this->enabled)
                        <x-jet-confirms-password wire:then="enableTwoFactorAuthentication">
                            <button class="btn btn-primary px-4" type="button" wire:loading.attr="disabled">{{ __('Enable') }}</button>
                        </x-jet-confirms-password>
                    @else
                        @if ($showingRecoveryCodes)
                            <x-jet-confirms-password wire:then="regenerateRecoveryCodes">
                                <button class="btn btn-primary px-4">{{ __('Regenerate Recovery Codes') }}</button>
                            </x-jet-confirms-password>
                        @elseif ($showingConfirmation)
                            <x-jet-confirms-password wire:then="confirmTwoFactorAuthentication">
                                <button class="btn btn-primary px-4" type="button" wire:loading.attr="disabled">{{ __('Confirm') }}</button>
                            </x-jet-confirms-password>
                        @else
                            <x-jet-confirms-password wire:then="showRecoveryCodes">
                                <button class="btn btn-secondary px-4">{{ __('Show Recovery Codes') }}</button>
                            </x-jet-confirms-password>
                        @endif

                        @if ($showingConfirmation)
                            <x-jet-confirms-password wire:then="disableTwoFactorAuthentication">
                                <button class="btn btn-secondary px-4" wire:loading.attr="disabled">{{ __('Cancel') }}</button>
                            </x-jet-confirms-password>
                        @else
                            <x-jet-confirms-password wire:then="disableTwoFactorAuthentication">
                                <button class="btn btn-danger px-4" wire:loading.attr="disabled">{{ __('Disable') }}</button>
                            </x-jet-confirms-password>
                        @endif

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
