<div class="row mb-5">
    <div class="col-sm-3">
        <h3 class="fs-sm-18">{{ __('Browser Sessions') }}</h3>
        <p>{{ __('Manage and log out your active sessions on other browsers and devices.') }}</p>
    </div>
    <div class="col-sm-9">
        <div class="shadow rounded-4">
            <div class="p-4">
                <div class="text-muted mb-4">
                    {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
                </div>

                @if (count($this->sessions) > 0)
                    <!-- Other Browser Sessions -->
                    @foreach ($this->sessions as $session)
                        <div class="d-flex align-items-center">
                            <div>
                                @if ($session->agent->isDesktop())
                                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24"><path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path></svg>
                                @endif
                            </div>

                            <div class="ms-3">
                                <div>{{ $session -> agent -> platform() ? $session -> agent -> platform() : 'Unknown' }} - {{ $session -> agent -> browser() ? $session -> agent -> browser() : 'Unknown' }}</div>

                                <div class="fs-sm-12 text-muted">
                                    {{ $session -> ip_address }},

                                    @if ( $session -> is_current_device )
                                        <span class="text-success fw-500">{{ __('This device') }}</span>
                                    @else
                                        {{ __('Last active') }} {{ $session->last_active }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="d-flex align-items-center mt-4">
                    <button class="btn btn-primary" wire:click="confirmLogout" wire:loading.attr="disabled">{{ __('Log Out Other Browser Sessions') }}</button>

                    <x-jet-action-message class="ms-3" on="loggedOut">{{ __('Done.') }}</x-jet-action-message>
                </div>

                <!-- Log Out Other Devices Confirmation Modal -->
                <x-jet-dialog-modal wire:model="confirmingLogout">
                    <x-slot name="title">
                        {{ __('Log Out Other Browser Sessions') }}
                    </x-slot>

                    <x-slot name="content">
                        {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}

                        <div class="my-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="password" class="form-control" placeholder="{{ __('Password') }}" x-ref="password" wire:model.defer="password" wire:keydown.enter="logoutOtherBrowserSessions" />
                                </div>
                            </div>

                            @error('password')
                                <span class="text-danger fs-sm-14">{{ $message }}</span>
                            @enderror
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <button class="btn btn-secondary" wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">{{ __('Cancel') }}</button>

                        <button class="btn btn-success ms-3" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled">{{ __('Log Out Other Browser Sessions') }}</button>
                    </x-slot>
                </x-jet-dialog-modal>
            </div>
        </div>
    </div>
</div>