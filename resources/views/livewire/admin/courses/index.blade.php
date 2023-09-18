<div>
    <x-slot name="titlePage">- Cursos</x-slot>

    <div class="d-sm-flex justify-content-between align-items-center">
        <div>
            <h1 class="fs-sm-21 fw-700 mb-1">Cursos</h1>
            <h2 class="fs-sm-14 text-muted">Listado de tus cursos</h2>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary py-3 px-4 lh-1 rounded-4">Agregar curso</a>
    </div>

    @php
        $status_value = ['Inactivo', 'Activo'];
        $status_color = ['warning', 'success'];
    @endphp

    <div class="shadow p-4 rounded-4 mt-5">
        @if ( $courses -> count() )

            <table class="table table-borderless">
                <thead class="fs-sm-14 text-muted opacity-50 text-uppercase border-bottom">
                    <th class="ps-0">Nombre</th>
                    <th class="text-center">Inscripción</th>
                    <th></th>
                    <th class="text-center">F. de publicación</th>
                    <th></th>
                </thead>
                <tbody class="fs-sm-14">
                    @foreach ($courses as $course)
                        <tr class="border-bottom-dashed align-middle">
                            <td class="py-3">
                                <div class="d-flex align-items-center">
                                    <div class="ratio ratio-1x1 rounded-4 bg-img me-3" style="background-image: url('{{ asset($course -> cover) }}'); width: 48px;"></div>

                                    <span class="fs-sm-16 fw-600">{{ $course -> name }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                @if ( $course -> suscription_enable )
                                    <img src="{{ asset('img/icos/ico-check.svg') }}" width="16">
                                @else
                                    <img src="{{ asset('img/icos/ico-check.svg') }}" width="16" class="f-gray">
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge text-bg-{{ $status_color[$course -> status] }}">{{ $status_value[$course -> status] }}</span>
                            </td>
                            <td class="text-center">
                                {{ $course -> posted_at -> format('d/m/Y') }}
                            </td>
                            <td class="text-end pe-0">
                                <div class="dropdown">
                                    <button class="bg-light rounded-circle border-0 p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{ asset('img/icos/ico-dots.svg') }}" width="16" height="16" class="d-block"></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('admin.courses.show', $course) }}">Ver información</a></li>
                                        @if ( $course -> status )
                                            <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas deshabilitar el curso?') || event.stopImmediatePropagation()" wire:click="status('{{ $course -> slug }}',0)">Deshabilitar</button></li>
                                        @else
                                            <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas habilitar el curso?') || event.stopImmediatePropagation()" wire:click="status('{{ $course -> slug }}',1)">Habilitar</button></li>
                                        @endif
                                        @if ( $course -> suscription_enable )
                                            <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas deshabilitar la inscripción al curso?') || event.stopImmediatePropagation()" wire:click="suscription('{{ $course -> slug }}',0)">Deshabilitar inscripción</button></li>
                                        @else
                                            <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas habilitar la inscripción al curso?') || event.stopImmediatePropagation()" wire:click="suscription('{{ $course -> slug }}',1)">Habilitar inscripción</button></li>
                                        @endif
                                        <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="destroy('{{ $course -> slug }}')">Eliminar</button></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-sm-flex justify-content-between py-2">
                <select class="bg-light border rounded-3 px-2" wire:model="paginate">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>

                {{ $courses -> withQueryString() -> onEachSide(1) -> links() }}
            </div>

        @else

            <div class="py-5">
                <img src="{{ asset('img/panel/think.svg') }}" width="128" class="d-block mx-auto mb-3">
                <p class="text-center">No hay cursos aquí.</p>
            </div>

        @endif  
    </div>
</div>
