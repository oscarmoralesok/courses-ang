<div class="row mb-5">
    <div class="col-sm-3">
        <h3 class="fs-sm-18">{{ __('Delete Account') }}</h3>
        <p>{{ __('Permanently delete your account.') }}</p>
    </div>
    <div class="col-sm-9">
        <div class="shadow rounded-4">
            <div class="p-4">
                <div class="text-muted">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</div>

                <div class="mt-4">
                    <button class="btn btn-danger px-4" wire:click="confirmUserDeletion" wire:loading.attr="disabled">{{ __('Delete Account') }}</button>
                </div>

                <!-- Delete User Confirmation Modal -->
                <x-jet-dialog-modal wire:model="confirmingUserDeletion">
                    <x-slot name="title">{{ __('Delete Account') }}</x-slot>

                    <x-slot name="content">
                        {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                        <div class="my-3" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                            <div class="row">
                                <div class="col-md-3">
                                    <input class="form-control" type="password" placeholder="{{ __('Password') }}" x-ref="password" wire:model.defer="password" wire:keydown.enter="deleteUser" />
                                </div>
                            </div>

                            @error('password')
                                <span class="text-danger fs-sm-14">{{ $message }}</span>
                            @enderror
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <button class="btn btn-secondary px-4" wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">{{ __('Cancel') }}</button>

                        <button class="btn btn-success px-4 ms-3" wire:click="deleteUser" wire:loading.attr="disabled">{{ __('Delete Account') }}</button>
                    </x-slot>
                </x-jet-dialog-modal>
            </div>
        </div>
    </div>
</div>
