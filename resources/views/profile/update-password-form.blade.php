<form wire:submit.prevent="updatePassword" class="mb-5">
    <div class="row">
        <div class="col-sm-3">
            <h3 class="fs-sm-18">{{ __('Update Password') }}</h3>
            <p>{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
        </div>
        <div class="col-sm-9">
            <div class="shadow rounded-4">
                <div class="p-4">
                    <div class="mb-3">
                        <label>{{ __('Current Password') }}</label>
                        <input id="current_password" type="password" class="form-control" wire:model.defer="state.current_password" />
                        @error('current_password')
                            <span class="text-danger fs-sm-14">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>{{ __('New Password') }}</label>
                        <input id="password" type="password" class="form-control" wire:model.defer="state.password" />
                        @error('password')
                            <span class="text-danger fs-sm-14">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>{{ __('Confirm Password') }}</label>
                        <input id="password_confirmation" type="password" class="form-control" wire:model.defer="state.password_confirmation" />
                        @error('password_confirmation')
                            <span class="text-danger fs-sm-14">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="p-4 border-top d-flex justify-content-end">
                    <x-jet-action-message class="me-3" on="saved">Actualizado</x-jet-action-message>

                    <button class="btn btn-primary px-4 ms-3">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
