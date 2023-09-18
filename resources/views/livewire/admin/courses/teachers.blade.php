<div>
    <x-slot name="titlePage">- Profesores</x-slot>

    @include('partials.admin.aside-course')

    <div class="contentEvent">
        <div class="px-5">
            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fs-sm-21 fw-700 mb-1">Profesores</h1>
                    <h2 class="fs-sm-14 text-muted">Profesores del Curso</h2>
                </div>
            </div>

            <div class="bg-light p-3 rounded-4 mb-4 text-nowrap overflow-auto">
                @forelse ($teachers as $teacher)
                    <div class="d-inline-block text-center me-3 text-wrap lh-1" style="width: 80px;">
                        <div class="ratio ratio-1x1 bg-img rounded-4" style="background-image: url({{ asset($teacher -> photo) }});">
                            <button wire:click="addTeacher({{ $teacher -> id }})" wire:loading.attr="disabled" wire:target="addTeacher({{ $teacher -> id }})" class="bg-transparent border-0 btadd justify-content-center d-flex align-items-center">
                                <img src="{{ asset('img/icos/ico-plus.svg') }}" width="24">
                            </button>
                        </div>
                        <span class="fs-sm-12 mt-2 d-inline-block" style="min-height: 24px">{{ $teacher -> name }}</span>
                    </div>
                @empty
                    <p class="py-5 text-center">No hay profesores para añadir</p>
                @endforelse
            </div>

            <h3 class="fs-sm-21 fw-700 mb-4">Profesores del curso</h3>
            <div class="row">
                @forelse ($course -> teachers as $tchr)
                    <div class="col-sm-2 text-center mb-4">
                        <div class="ratio ratio-1x1 rounded-4 bg-img" style="background-image: url('{{ asset($tchr -> photo) }}')">
                            <div>
                                <button onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="detachTeacher({{ $tchr -> id }})" wire:loading.attr="disabled" wire:target="detachTeacher({{ $tchr -> id }})" class="border-0 bg-danger rounded-circle text-center d-flex align-items-center position-absolute top-0 end-0 mt-2 me-2" style="height: 30px; width: 30px;"><img src="{{ asset('img/icos/ico-delete.svg') }}" class="f-invert"></button>
                            </div>
                        </div>
                        <h4 class="fs-sm-16 mt-2">{{ $tchr -> name }}</h4>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="{{ asset('img/panel/think.svg') }}" width="120">
                        <p class="m-0">No hay profesores añadidos al curso.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
