<div>
    <x-slot name="titlePage">- Estudiantes</x-slot>

    @include('partials.admin.aside-course')

    <div class="contentEvent">
        <div class="px-5">
            <div class="d-sm-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fs-sm-21 fw-700 mb-1">Alumnos</h1>
                    <h2 class="fs-sm-14 text-muted">Alumnos del curso</h2>
                </div>
            </div>

            <div class="mt-4 d-flex align-items-center">
                <div class="border rounded-3 d-flex align-items-center overflow-hidden">
                    <img src="{{ asset('img/icos/ico-search.svg') }}" width="24" class="ms-2">
                    <input type="text" class="border-0 fs-sm-21 px-2 py-2" wire:model="search" placeholder="Buscar alumno">
                </div>
            </div>

            @php
                $status_value = ['Inactivo', 'Activo'];
                $status_color = ['warning', 'success'];
            @endphp

            <div class="shadow p-4 rounded-4 mt-5">
                @if ( $students -> count() )

                    <table class="table table-borderless">
                        <thead class="fs-sm-14 text-muted opacity-50 text-uppercase border-bottom">
                            <th class="ps-0">Nombre</th>
                            <th>Contacto</th>
                            <th class="text-center">F. de nac.</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody class="fs-sm-14">
                            @foreach ($students as $student)
                                <tr class="border-bottom-dashed align-middle">
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            @if ( $student -> profile_photo_path ) 
                                                @php
                                                    $photo = asset($student -> profile_photo_path);
                                                @endphp
                                            @elseif ( $student -> socialProfiles -> count() )
                                                @php
                                                    $photo = $student -> socialProfiles -> first() -> social_avatar;
                                                @endphp
                                            @else
                                                @php
                                                    $photo = $student -> profile_photo_url;
                                                @endphp
                                            @endif
                                            <div class="ratio ratio-1x1 rounded-4 bg-img me-3" style="background-image: url({{ $photo }}); width: 48px;"></div>
                                            
                                            <span class="fs-sm-16 fw-600">{{ $student -> name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset('img/icos/ico-email.svg') }}" width="16"> {{ $student -> email }}
                                        @if ( $student -> student -> phone )
                                            <br><img src="{{ asset('img/icos/ico-phone.svg') }}" width="16"> {{ $student -> student -> phone }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $student -> student -> birthdate ? $student -> student -> birthdate -> format('d/m/Y') : '' }}</td>
                                    <td class="text-center">
                                        <span class="badge text-bg-{{ $status_color[$student -> status] }}">{{ $status_value[$student -> status] }}</span>
                                    </td>
                                    <td class="text-end pe-0">
                                        <div class="dropdown">
                                            <button class="bg-light rounded-circle border-0 p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{ asset('img/icos/ico-dots.svg') }}" width="16" height="16" class="d-block"></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="{{ route('admin.students.show', $student) }}">Ver información</a></li>
                                                @if ( $student -> status )
                                                    <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas deshabilitar al alumno?') || event.stopImmediatePropagation()" wire:click="status({{ $student -> id }}, 0)" wire:loading.attr="disabled" wire:target="status()">Deshabilitar</button></li>
                                                @else
                                                    <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas habilitar al alumno?') || event.stopImmediatePropagation()" wire:click="status({{ $student -> id }}, 1)" wire:loading.attr="disabled" wire:target="status()">Habilitar</button></li>
                                                @endif
                                                <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="destroy({{ $student -> id }})" wire:loading.attr="disabled" wire:target="destroy({{ $student -> id }})">Eliminar</button></li>
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

                        {{ $students -> withQueryString() -> onEachSide(1) -> links() }}
                    </div>

                    

                @else

                    <div class="py-5">
                        <img src="{{ asset('img/panel/think.svg') }}" width="128" class="d-block mx-auto mb-3">
                        <p class="text-center">No hay alumnos aquí.</p>
                    </div>

                @endif  
            </div>
        </div>
    </div>
</div>
