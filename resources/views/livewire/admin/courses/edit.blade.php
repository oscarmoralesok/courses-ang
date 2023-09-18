<div>
    <x-slot name="titlePage">- Editar Curso</x-slot>

    @include('partials.admin.aside-course')

    <div class="contentEvent">
        <div class="px-5">

            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="fs-sm-21 fw-700 mb-1">Cursos</h1>
                    <h2 class="fs-sm-14 text-muted">Editar curso</h2>
                </div>
                <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-light border py-3 px-4 lh-1 rounded-4">Volver al curso</a>
            </div>


            <div class="row">
                <div class="col-xl-3">
                    <div class="border-dashed bg-light br-10 p-4 mb-4">
                        <h2 class="fs-sm-18 mb-4">Imagen</h2>
                        <div class="ratio ratio-4x3 bg-img mx-auto rounded-4" style="background-image: url({{ asset(($cover) ? $cover -> temporaryUrl() : ($editArray['cover'] ?? 'img/panel/default.png')) }});">
                            <div>
                                <a onclick="$('.coverUpload').click()" class="rounded-circle shadow bg-white p-2 d-block position-absolute top-0 start-100 translate-middle"><img src="{{ asset('img/icos/ico-edit.svg') }}" width="16" height="16" class="float-start"></a>
                            </div>
                        </div>
                        <input class="coverUpload float-start" type="file" accept=".jpg,.png,.jpeg" wire:model="cover" style="height: 1px; opacity: 0; overflow: hidden; width: 1px;">
                        <span class="fs-sm-12 text-muted d-block text-center mt-3">Sólo se acepta imágenes en formato *.png, *.jpg and *.jpeg. Peso máximo 4MB.</span>
                        @error('cover')
                            <span class="fs-sm-12 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="border-dashed bg-light br-10 p-4 mb-4">
                        <h2 class="fs-sm-18 mb-3">Estado<span class="text-danger fs-sm-16">*</span></h2>
                        <div class="mb-3">
                            <select class="form-select rounded-3 py-2 fs-sm-14" wire:model.defer="editArray.status">
                                <option value="0">Borrador</option>
                                <option value="1">Activo</option>
                            </select>
                            @error('editArray.status')
                                <span class="fs-sm-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <label class="fs-sm-14 mb-1">F. de publicación<span class="text-danger fs-sm-16">*</span></label>
                        <input class="form-control datetimepicker" id="posted_at" type="text" readonly wire:model.defer="editArray.posted_at">
                        @error('editArray.posted_at')
                            <span class="fs-sm-12 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="border-dashed bg-light br-10 p-4 mb-4">
                        <h2 class="fs-sm-18 mb-3">Detalle</h2>

                        <div class="mb-3">
                            <label class="fs-sm-14 fw-600 mb-1">Inscripción<span class="text-danger fs-sm-16">*</span></label>
                            <select class="form-select rounded-3 py-2 fs-sm-14" wire:model.defer="editArray.suscription_enable">
                                <option value="1">Abierta</option>
                                <option value="0">Cerrada</option>
                            </select>

                            @error('editArray.suscription_enable')
                                <span class="fs-sm-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="fs-sm-14 fw-600 mb-1">Precio AR$<span class="text-danger fs-sm-16">*</span></label>
                            <input class="form-control" type="number" wire:model.defer="editArray.price_ars">

                            @error('editArray.price_ars')
                                <span class="fs-sm-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="fs-sm-14 fw-600 mb-1">Precio u$d<span class="text-danger fs-sm-16">*</span></label>
                            <input class="form-control" type="number" wire:model.defer="editArray.price_usd">

                            @error('editArray.price_usd')
                                <span class="fs-sm-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="col-xl-9">
                    <div class="border-dashed bg-light br-10 p-4 mb-4">
                        <div class="mb-3">
                            <label class="fs-sm-13 opacity-75">Título<span class="text-danger fs-sm-16">*</span></label>
                            <input class="form-control fs-sm-21" type="text" wire:model="editArray.name">

                            @error('editArray.name')
                                <span class="fs-sm-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="fs-sm-13 opacity-75">Contenido<span class="text-danger fs-sm-16">*</span></label>

                            <div wire:ignore>
                                <textarea id="editor">{{ $editArray['description'] }}</textarea>
                            </div>

                            @error('editArray.description')
                                <span class="fs-sm-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <label class="fs-sm-13 opacity-75">Extracto</label>
                        <textarea class="form-control" wire:model.defer="editArray.excerpt"></textarea>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-success py-2 px-4 rounded-3" wire:click="udpate" wire:loading.attr="disabled" wire:target="cover, udpate">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('vendor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
        <script type="text/javascript">
            flatpickr(".datetimepicker", {
                enableTime: false,
                dateFormat: "d/m/Y",
                defaultDate: "{{ $editArray['posted_at'] }}",
                locale: "es",
            });

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
