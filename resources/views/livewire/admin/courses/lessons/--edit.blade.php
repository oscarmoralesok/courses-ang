<div>
    <x-slot name="titlePage">- Lecciones</x-slot>

    @include('partials.admin.aside-course')

    <div class="contentEvent">
        <div class="px-5">
            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fs-sm-21 fw-700 mb-1">Lecciones</h1>
                    <h2 class="fs-sm-14 text-muted">Editar lección</h2>
                </div>
                <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-light py-3 px-4 lh-1 rounded-4">Volver al curso</a>
            </div>

            <div class="row">
                <div class="col-9 pe-1 pe-sm-3 mb-3">
                    <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                        <label class="fs-sm-14 text-muted">Título de la lección<span class="text-danger fs-sm-16">*</span></label><br>
                        <input class="border-0 bg-transparent w-100 fs-sm-21" type="text" wire:model="editArray.title" autofocus />
                    </div>

                    @error('editArray.title')
                        <span class="fs-sm-14 text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-3 ps-1 ps-sm-3 mb-3">
                    <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                        <label class="fs-sm-14 text-muted">Nº<span class="text-danger fs-sm-16">*</span></label><br>
                        <input class="border-0 bg-transparent w-100 fs-sm-21" type="number" wire:model.defer="editArray.number" />
                    </div>

                    @error('editArray.number')
                        <span class="fs-sm-14 text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <div wire:ignore><textarea id="editor">{{ $editArray['description'] }}</textarea></div>

                @error('editArray.description')
                    <span class="fs-sm-14 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3" style="width: 200px">
                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                    <label class="fs-sm-14 text-muted">Duración de la clase<span class="text-danger fs-sm-16">*</span></label>
                    <input class="border-0 bg-transparent w-100" type="text" name="duration" wire:model.defer="editArray.duration">
                </div>

                @error('editArray.duration')
                    <span class="fs-sm-14 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <hr>

            <h5 class="mt-3">Videos</h5>
            <div class="row mb-3">
                @forelse ($lesson -> videos -> sortBy('number') as $video)
                    <div class="col-sm-3 mb-3">
                        @php $codevideo = explode('/', $video -> url) @endphp
                        <div class="ratio ratio-16x9">
                            <iframe class="rounded-4" src="https://player.vimeo.com/video/{{ end($codevideo) }}?h=a3bf0affdd&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            <div>
                                <a wire:click="editVideo({{ $video -> id }})" data-bs-toggle="modal" data-bs-target="#editVideo" class="rounded-circle shadow bg-white p-2 d-block position-absolute top-0 translate-middle" style="right: 10px;"><img src="{{ asset('img/icos/ico-edit.svg') }}" width="16" height="16" class="d-block"></a>
                                <a onclick="confirm('¿Seguro que deseas eliminar este archivo?') || event.stopImmediatePropagation()" wire:click="destroyVideo({{ $video -> id }})" class="rounded-circle shadow bg-white p-2 d-block position-absolute top-0 start-100 translate-middle"><img src="{{ asset('img/icos/ico-delete.svg') }}" width="16" height="16" class="d-block"></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><p class="fs-14 text-muted text-center">No hay videos cargados</p></div>
                @endforelse
            </div>

            @error('videoArray')
                <span class="fs-sm-14 text-danger">{{ $message }}</span>
            @enderror

            @for ($i = 0; $i < $q_videos; $i++)
                <div class="row align-items-start">
                    <div class="col-9 pe-1 pe-sm-3">
                        <div class="mb-3">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">URL de Video<span class="text-danger fs-sm-16">*</span></label>
                                <input class="border-0 bg-transparent w-100" type="url" wire:model.defer="videoArray.{{ $i }}.url">
                            </div>

                            @error('videoArray.{{ $i }}.url')
                                <span class="fs-sm-14 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 ps-1 ps-sm-3">
                        <div class="mb-3">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">Nro.<span class="text-danger fs-sm-16">*</span></label>
                                <input class="border-0 bg-transparent w-100" type="number" wire:model.defer="videoArray.{{ $i }}.number">
                            </div>

                            @error('videoArray.{{ $i }}.number')
                                <span class="fs-sm-14 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            @endfor

            <a class="btn btn-primary text-white btn-sm rounded-3" wire:click="addVideo">Añadir más videos</a>

            <hr>

            <h5 class="mt-3">Archivos</h5>

            <div class="row mb-3">
                @forelse ($lesson -> archives -> sortBy('number') as $archive)
                    <div class="col-sm-3 mb-3">
                        <div class="position-relative">
                            <a  onclick="confirm('¿Seguro que deseas eliminar este archivo?') || event.stopImmediatePropagation()" wire:click="destroyArchive({{ $archive -> id }})" class="rounded-circle shadow bg-white p-2 d-block position-absolute top-0 start-100 translate-middle"><img src="{{ asset('img/icos/ico-delete.svg') }}" width="16" height="16" class="float-start"></a>
                            <a class="btn btn-light border w-100" href="{{ asset($archive -> path) }}" target="_blank">{{ $archive -> name }}</a>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><p class="fs-14 text-muted text-center">No hay archivos cargados</p></div>
                @endforelse
            </div>

            @for ($e = 0; $e < $q_files; $e++)
                <div class="row">
                    <div class="col-sm-5 mb-3">
                        <div class="bg-secondary bg-opacity-10 px-3 py-2 rounded-4">
                            <label class="fs-sm-14 text-muted">Archivo</label>
                            <input class="border-0 bg-transparent w-100" type="file" wire:model.defer="filesArray.{{ $e }}.file">
                        </div>
                    </div>
                    <div class="col-sm-5 mb-3">
                        <div class="mb-3">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">Nombre del archivo</label>
                                <input class="border-0 bg-transparent w-100" type="text" wire:model.defer="filesArray.{{ $e }}.name">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 mb-3">
                        <div class="mb-3">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">Orden</label>
                                <input class="border-0 bg-transparent w-100" type="number" wire:model.defer="filesArray.{{ $e }}.number">
                            </div>
                        </div>
                    </div>
                </div>
            @endfor

            <a class="btn btn-primary text-white btn-sm rounded-3" wire:click="addFile">Añadir más archivos</a>

            <hr>

            <button class="btn btn-success py-3 px-5 rounded-4" wire:click="update" wire:loading.attr="disabled" wire:target="update">Guardar</button>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('vendor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
        <script type="text/javascript">
            ClassicEditor.create( document.querySelector( '#editor' ), {
                simpleUpload: {
                    uploadUrl: '{{ route('image.upload') }}',
                },
                mediaEmbed: {
                    previewsInData: true,
                },
            })
             .then(function(editor){
                editor.model.document.on('change:data', () => {
                    @this.set('editArray.description', editor.getData())
                })
            })
             .catch( error => {
                console.error( error );
            });
        </script>
    @endpush
</div>
