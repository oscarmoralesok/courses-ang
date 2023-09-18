<div>
    <x-slot name="titlePage">- Examen</x-slot>

    @include('partials.admin.aside-course')

    <div class="contentEvent">
        <div class="px-5">

            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fs-sm-21 fw-700 mb-1">Cursos</h1>
                    <h2 class="fs-sm-14 text-muted">Examen del módulo</h2>
                </div>
                <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-light border py-3 px-4 lh-1 rounded-4">Volver al listado de módulos</a>
            </div>

            <div class="d-sm-flex justify-content-between align-items-end mb-4">
                <div>
                    <span class="badge text-uppercase bg-{{ $module -> exam_status ? 'success' : 'secondary' }}">{{ $module -> exam_status ? 'Habilitado' : 'Deshabilitado' }}</span>
                    <h1 class="fs-sm-21 fw-400">Exámen de módulo <strong>{{ $module -> name }}</strong></h1>
                </div>

                <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addQuestion">Agregar pregunta</a></li>
                        @if ( $module -> exam_status )
                            <li><a class="dropdown-item" onclick="confirm('¿Confirma la deshabilitación este examen?') || event.stopImmediatePropagation()" wire:click="statusExam(0)">Deshabilitar</a></li>
                        @else
                            <li><a class="dropdown-item" onclick="confirm('¿Confirma la habilitación este examen?') || event.stopImmediatePropagation()" wire:click="statusExam(1)">Habilitar</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            @foreach ($questions as $question)
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <strong>{{ $question -> question }}</strong>

                            <div class="text-nowrap ms-3">
                                <button class="btn btn-light border tooltipToggle" title="Agregar respuesta" data-bs-toggle="modal" data-bs-target="#addAnswer" wire:click="$set('addAnswerArray.question_id', {{ $question -> id }})"><img src="{{ asset('img/icos/ico-plus-2.svg') }}" width="16"></button>
                                <button class="btn btn-light border tooltipToggle" title="Editar pregunta" data-bs-toggle="modal" data-bs-target="#editQuestion" wire:click="editQuestion('{{ $question -> id }}')"><img src="{{ asset('img/icos/ico-edit.svg') }}" width="16"></button>
                                <button class="btn btn-light border" onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="destroyQuestion('{{ $question -> id }}')" wire:loading.attr="disabled" wire:target="destroyQuestion('{{ $question -> id }}')"><img src="{{ asset('img/icos/ico-delete.svg') }}" width="16"></button>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($question -> answers as $answer )
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    {{ $answer -> answer }}

                                    <div class="text-nowrap">
                                        @if ( $answer -> correct )
                                            <img src="{{ asset('img/icos/ico-check.svg') }}" width="16" class="me-2">
                                        @else
                                            <img src="{{ asset('img/icos/ico-invalid.svg') }}" width="16" class="me-2">
                                        @endif
                                        |
                                        <button class="btn btn-light border ms-2 tooltipToggle" title="Editar respuesta" data-bs-toggle="modal" data-bs-target="#editAnswer" wire:click="editAnswer('{{ $answer -> id }}')"><img src="{{ asset('img/icos/ico-edit.svg') }}" width="16"></button>
                                        <button class="btn btn-light border" onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="destroyAnswer('{{ $answer -> id }}')" wire:loading.attr="disabled" wire:target="destroyAnswer('{{ $answer -> id }}')"><img src="{{ asset('img/icos/ico-delete.svg') }}" width="16"></button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="addAnswer" tabindex="-1" aria-labelledby="addAnswerLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div wire:loading wire:target="addAnswer" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header border-bottom-dashed p-4">
                    <h1 class="fs-sm-16" id="addAnswerLabel">Agregar respuesta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                            <label class="fs-sm-14 text-muted">Respuesta</label>
                            <input class="border-0 bg-transparent w-100" type="text" wire:model="addAnswerArray.answer" placeholder="Respuesta" />
                        </div>

                        @error('addAnswerArray.answer')
                            <span class="fs-sm-12 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-6 d-flex align-items-center">
                            <div class="mb-3">
                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                    <label class="fs-sm-14 text-muted d-block">Correcta</label>
                                    <label class="me-3">
                                        <input class="form-check-input" type="radio" name="correct" value="1" wire:model.defer="addAnswerArray.correct"> Si
                                    </label>
                                    <label>
                                        <input class="form-check-input" type="radio" name="correct" value="0" wire:model.defer="addAnswerArray.correct"> N0
                                    </label>
                                </div>

                                @error('addAnswerArray.correct')
                                    <span class="fs-sm-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="addAnswer" wire:loading.attr="disabled" wire:target="addAnswer">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="editAnswer" tabindex="-1" aria-labelledby="editAnswerLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div wire:loading wire:target="editAnswer, updateAnswer" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header border-bottom-dashed p-4">
                    <h1 class="fs-sm-16" id="editAnswerLabel">Agregar respuesta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                            <label class="fs-sm-14 text-muted">Respuesta</label>
                            <input class="border-0 bg-transparent w-100" type="text" wire:model="editAnswerArray.answer" placeholder="Respuesta" />
                        </div>

                        @error('editAnswerArray.answer')
                            <span class="fs-sm-12 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-6 d-flex align-items-center">
                            <div class="mb-3">
                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                    <label class="fs-sm-14 text-muted d-block">Correcta</label>
                                    <label class="me-3">
                                        <input class="form-check-input" type="radio" name="correct" value="1" wire:model.defer="editAnswerArray.correct"> Si
                                    </label>
                                    <label>
                                        <input class="form-check-input" type="radio" name="correct" value="0" wire:model.defer="editAnswerArray.correct"> N0
                                    </label>
                                </div>

                                @error('editAnswerArray.correct')
                                    <span class="fs-sm-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="updateAnswer" wire:loading.attr="disabled" wire:target="updateAnswer">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="addQuestion" tabindex="-1" aria-labelledby="addQuestionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div wire:loading wire:target="addQuestion" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header border-bottom-dashed p-4">
                    <h1 class="fs-sm-16" id="addQuestionLabel">Agregar pregunta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                            <label class="fs-sm-14 text-muted">Pregunta</label>
                            <input class="border-0 bg-transparent w-100" type="text" wire:model="addQuestionArray.question" />
                        </div>

                        @error('addQuestionArray.question')
                            <span class="fs-sm-12 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-6 d-flex align-items-center">
                            <div class="mb-3">
                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                    <label class="fs-sm-14 text-muted d-block">Orden</label>
                                    <input class="border-0 bg-transparent w-100" type="number" wire:model="addQuestionArray.number" />
                                </div>

                                @error('addQuestionArray.number')
                                    <span class="fs-sm-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="addQuestion" wire:loading.attr="disabled" wire:target="addQuestion">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="editQuestion" tabindex="-1" aria-labelledby="editQuestionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div wire:loading wire:target="editQuestion, updateQuestion" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header border-bottom-dashed p-4">
                    <h1 class="fs-sm-16" id="editQuestionLabel">Editar pregunta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                            <label class="fs-sm-14 text-muted">Pregunta</label>
                            <input class="border-0 bg-transparent w-100" type="text" wire:model="editQuestionArray.question" />
                        </div>

                        @error('editQuestionArray.question')
                            <span class="fs-sm-12 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-6 d-flex align-items-center">
                            <div class="mb-3">
                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                    <label class="fs-sm-14 text-muted d-block">Orden</label>
                                    <input class="border-0 bg-transparent w-100" type="number" wire:model="editQuestionArray.number" />
                                </div>

                                @error('editQuestionArray.number')
                                    <span class="fs-sm-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="updateQuestion" wire:loading.attr="disabled" wire:target="updateQuestion">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

</div>