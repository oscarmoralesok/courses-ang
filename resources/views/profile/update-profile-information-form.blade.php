<form wire:submit.prevent="updateProfileInformation" class="mb-5">
    <div class="row">
        <div class="col-sm-3">
            <h3 class="fs-sm-18">{{ __('Profile Information') }}</h3>
            <p>{{ __('Update your account\'s profile information and email address.') }}</p>
        </div>
        <div class="col-sm-9">
            <div class="shadow rounded-4">
                <div class="p-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div x-data="{photoName: null, photoPreview: null}" class="mb-4">
                            <!-- Profile Photo File Input -->
                            <input type="file" class="d-none" wire:model="photo" x-ref="photo" x-on:change="photoName = $refs.photo.files[0].name; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($refs.photo.files[0]);" />

                            <label>{{ __('Photo') }}</label>

                            <!-- Current Profile Photo -->
                            <div class="mt-2" x-show="! photoPreview">
                                <img src="{{ Auth::user() -> profile_photo_url }}" alt="{{ $this -> user -> name }}" class="rounded-3">
                            </div>

                            <!-- New Profile Photo Preview -->
                            <div class="mt-2" x-show="photoPreview" style="display: none;">
                                <span class="d-block rounded-3" x-bind:style="'background-image: url(\'' + photoPreview + '\');'"></span>
                            </div>

                            <button class="btn btn-secondary mt-2" type="button" x-on:click.prevent="$refs.photo.click()">{{ __('Select A New Photo') }}</button>

                            @if ($this->user->profile_photo_path)
                                <button type="button" class="btn btn-danger mt-2" wire:click="deleteProfilePhoto">{{ __('Remove Photo') }}</button>
                            @endif

                        @error('photo')
                            <span class="text-danger fs-sm-14">{{ $message }}</span>
                        @enderror
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-6">
                            <label>{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control" wire:model.defer="state.name" />
                            @error('name')
                                <span class="text-danger fs-sm-14">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label>{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control" wire:model.defer="state.email" />
                            @error('email')
                                <span class="text-danger fs-sm-14">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="p-4 d-flex justify-content-end align-items-center border-top">
                    <x-jet-action-message class="mr-3 text-success" on="saved">Actualizado</x-jet-action-message>

                    <button class="btn btn-primary px-4 ms-3" wire:loading.attr="disabled" wire:target="photo">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
