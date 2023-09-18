<div>
    <x-slot name="titlePage">- Informanción de Alumno</x-slot>

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fs-sm-21 fw-700 mb-1">Alumnos</h1>
            <h2 class="fs-sm-14 text-muted">Informanción de Alumno</h2>
        </div>
        <a href="{{ route('admin.students.index') }}" class="btn btn-light border py-3 px-4 lh-1 rounded-4">Volver al listado</a>
    </div>

    @php
        $status_value = ['Inactivo', 'Activo'];
        $status_color = ['warning', 'success'];
        $membership_value = ['Sin membresía', 'Membresía Basic', 'Membresía Full'];
        $membership_color = ['light', 'primary', 'danger'];
    @endphp

    <div class="border-dashed p-4 pb-0 rounded-4 mb-4">
        <div class="d-sm-flex">
            <div class="pe-4">
                @php
                    if ( $student -> profile_photo_path ) :
                        $photo = asset($student -> profile_photo_path);
                    elseif ( $student -> socialProfiles -> count() ) :
                        $photo = $student -> socialProfiles -> first() -> social_avatar;
                    else :
                        $photo = $student -> profile_photo_url;
                    endif;
                @endphp
                <div class="ratio ratio-1x1 rounded-4 bg-img" style="background-image: url('{{ $photo }}'); width: 128px;"></div>
            </div>
            <div class="flex-fill">
                <div class="d-sm-flex align-items-center">
                    <span class="order-2 ms-sm-2 badge text-bg-{{ $status_color[$student -> status] }}">{{ $status_value[$student -> status] }}</span>
                    <h1 class="order-1 fs-sm-32 fw-600 mt-2">{{ $student -> name }}</h1>
                </div>

                <span class="text-muted fs-sm-14 d-block mb-2">
                    <img src="{{ asset('img/icos/ico-email.svg') }}" width="16"> {{ $student -> email }}
                    @if ( $student -> student -> phone )
                        &nbsp; &nbsp; <img src="{{ asset('img/icos/ico-phone.svg') }}" width="16"> {{ $student -> student -> phone }}
                    @endif
                </span>

                <span class="badge fw-500 text-bg-{{ $student -> membership ? $membership_color[$student -> membership -> type] : $membership_color[0] }}">{{ $student -> membership ? $membership_value[$student -> membership -> type] : $membership_value[0] }}</span>
                <span class="text-muted fs-sm-13">{{ $student -> membership ? 'Vence el ' . $student -> membership -> expiration -> format('d/m/Y') : '' }}</span>
            </div>
            <div>
                <div class="dropdown">
                    <button class="bg-light rounded-circle border p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{ asset('img/icos/ico-dots.svg') }}" width="16" height="16" class="d-block"></button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a data-bs-toggle="modal" data-bs-target="#editInfoModal" class="dropdown-item">Editar información</a></li>
                        @if ( $student -> status )
                            <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas deshabilitar al alumno?') || event.stopImmediatePropagation()" wire:click="status({{ $student -> id }}, 0)" wire:loading.attr="disabled" wire:target="status()">Deshabilitar</button></li>
                        @else
                            <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas habilitar al alumno?') || event.stopImmediatePropagation()" wire:click="status({{ $student -> id }}, 1)" wire:loading.attr="disabled" wire:target="status()">Habilitar</button></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <ul class="nav nav-tabs border-0 mb-0 mt-3" id="myTab" wire:ignore role="tablist">
                <li class="nav-item me-4" role="presentation">
                    <button class="nav-link active px-0 border-0 rounded-0" id="course-tab" data-bs-toggle="tab" data-bs-target="#course-tab-pane" type="button" role="tab" aria-controls="course-tab-pane" aria-selected="true">Cursos</button>
                </li>
                <li class="nav-item me-4" role="presentation">
                    <button class="nav-link px-0 border-0 rounded-0" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments-tab-pane" type="button" role="tab" aria-controls="payments-tab-pane" aria-selected="false">Pagos</button>
                </li>
                <li class="nav-item me-4" role="presentation">
                    <button class="nav-link px-0 border-0 rounded-0" id="membership-tab" data-bs-toggle="tab" data-bs-target="#membership-tab-pane" type="button" role="tab" aria-controls="membership-tab-pane" aria-selected="false">Membresía</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-0 border-0 rounded-0" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-tab-pane" type="button" role="tab" aria-controls="info-tab-pane" aria-selected="false">Información general</button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="course-tab-pane" role="tabpanel" aria-labelledby="course-tab" wire:ignore.self tabindex="0">
            <div class="border-dashed br-10 mb-4">
                <div class="border-bottom-dashed px-4 py-3 d-flex justify-content-between align-items-center">
                    <h2 class="fs-sm-18 m-0 fw-500">Cursos</h2>

                    <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addCourseModal">Agregar curso</button>
                </div>
                <div class="p-4 position-relative">

                    <div wire:loading wire:target="resendEmail, detachCourse" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>

                    @if ( $student -> courses -> count() )
                        
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="fs-sm-14 text-muted text-uppercase">
                                        <th>Curso</th>
                                        <th>Lecciones</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($student -> courses -> sortByDesc('id') as $course)
                                        @php
                                            $ql = $course -> lessons -> count();
                                            $cl = $student -> completeLessons -> where('course_id', $course -> id) -> count();
                                        @endphp
                                        <tr class="border-bottom-dashed align-middle">
                                            <td>{{ $course -> name }}</td>
                                            <td>{{ $cl }} / {{ $ql }}</td>
                                            <td class="text-end">
                                                <a onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="detachCourse('{{ $course -> id }}')"><img src="{{ asset('img/icos/ico-delete.svg') }}" width="16" height="16"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else
                        <div class="py-5">
                            <img src="{{ asset('img/panel/think.svg') }}" width="128" class="d-block mx-auto mb-3">
                            <p class="text-center">No hay información aquí.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @php
            $status_value = [1 => 'Aprovado', 2 => 'Pendiente'];
            $status_color = [1 => 'success', 2 => 'warning'];
        @endphp

        <div class="tab-pane fade" id="payments-tab-pane" role="tabpanel" aria-labelledby="payments-tab" wire:ignore.self tabindex="0">
            <div class="border-dashed br-10 mb-4">
                <div class="border-bottom-dashed px-4 py-3 d-flex justify-content-between align-items-center">
                    <h2 class="fs-sm-18 m-0 fw-500">Pagos</h2>

                    <button data-bs-toggle="modal" data-bs-target="#addPayment" class="btn btn-primary px-4">Agregar pago</button>
                </div>
                <div class="p-4">
                    @if ( $student -> payments -> count() )
                        <table class="table table-borderless">
                            <thead>
                                <tr class="fs-sm-14 text-muted text-uppercase">
                                    <th class="ps-0">ID</th>
                                    <th>Curso</th>
                                    <th>Monto</th>
                                    <th class="text-center">Fecha</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student -> payments as $payment)
                                    <tr class="border-bottom-dashed align-middle">
                                        <td class="ps-0 py-3">{{ $payment -> payment_id }}</td>
                                        <td>{{ $payment -> course -> name }}</td>
                                        <td>
                                            {{ $payment -> gateway == 'MP' ? '$' : 'u$d' }}
                                            {{ number_format($payment -> amount, 2, ',', '.') }}
                                        </td>
                                        <td class="text-center">{{ $payment -> created_at -> format('d/m/Y') }}</td>
                                        <td class="text-center"><img src="{{ asset('img/icos/ico-' . $payment -> gateway . '.svg') }}" width="24" height="24"></td>
                                        <td class="text-center">
                                            <span class="badge text-bg-{{ $status_color[ $payment -> status ] }}">{{ $status_value[$payment -> status] }}</span>
                                        </td>
                                        <td class="pe-0 text-end">
                                            <div class="dropdown">
                                                <button class="bg-light rounded-circle border-0 p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{ asset('img/icos/ico-dots.svg') }}" width="16" height="16" class="d-block"></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if ( $payment -> status == 1 )
                                                        <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas pasar a pendiente el pago?') || event.stopImmediatePropagation()" wire:click="statusPayment({{ $payment -> id }}, 2)" wire:loading.attr="disabled" wire:target="statusPayment">Pasar a pendiente</button></li>
                                                    @else
                                                        <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas aprobar el pago?') || event.stopImmediatePropagation()" wire:click="statusPayment({{ $payment -> id }}, 1)" wire:loading.attr="disabled" wire:target="statusPayment">Aprobar</button></li>
                                                    @endif
                                                    <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editPayment" wire:click="editPayment({{ $payment -> id }})">Editar</button></li>
                                                    <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="destroyPayment({{ $payment -> id }})" wire:loading.attr="disabled" wire:target="destroyPayment">Eliminar</button></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="py-5">
                            <img src="{{ asset('img/panel/think.svg') }}" width="128" class="d-block mx-auto mb-3">
                            <p class="text-center">No hay información aquí.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="membership-tab-pane" role="tabpanel" aria-labelledby="membership-tab" wire:ignore.self tabindex="0">
            <div class="border-dashed br-10 mb-4">
                <div class="border-bottom-dashed px-4 py-3 d-flex justify-content-between align-items-center">
                    <h2 class="fs-sm-18 m-0 fw-500">Membresía</h2>
                </div>
                <div class="p-4">
                    @if ( $student -> membershipPayments -> count() )
                        <table class="table table-borderless">
                            <thead>
                                <tr class="fs-sm-14 text-muted text-uppercase">
                                    <th class="ps-0">ID</th>
                                    <th>Tipo</th>
                                    <th>Monto</th>
                                    <th class="text-center">Fecha</th>
                                    <th></th>
                                    <th></th>
                                    {{-- <th></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student -> membershipPayments as $payment)
                                    <tr class="border-bottom-dashed align-middle">
                                        <td class="ps-0 py-3">{{ $payment -> payment_id }}</td>
                                        <td>{{ $payment -> type == 1 ? 'Basic' : 'Full' }}</td>
                                        <td>
                                            {{ $payment -> gateway == 'MP' ? '$' : 'u$d' }}
                                            {{ number_format($payment -> amount, 2, ',', '.') }}
                                        </td>
                                        <td class="text-center">{{ $payment -> created_at -> format('d/m/Y') }}</td>
                                        <td class="text-center"><img src="{{ asset('img/icos/ico-' . $payment -> gateway . '.svg') }}" width="24" height="24"></td>
                                        <td class="text-center">
                                            <span class="badge text-bg-{{ $status_color[ $payment -> status ] }}">{{ $status_value[$payment -> status] }}</span>
                                        </td>
                                        {{--<td class="pe-0 text-end">
                                            <div class="dropdown">
                                                <button class="bg-light rounded-circle border-0 p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{ asset('img/icos/ico-dots.svg') }}" width="16" height="16" class="d-block"></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if ( $payment -> status == 1 )
                                                        <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas pasar a pendiente el pago?') || event.stopImmediatePropagation()" wire:click="statusPayment({{ $payment -> id }}, 2)" wire:loading.attr="disabled" wire:target="statusPayment">Pasar a pendiente</button></li>
                                                    @else
                                                        <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas aprobar el pago?') || event.stopImmediatePropagation()" wire:click="statusPayment({{ $payment -> id }}, 1)" wire:loading.attr="disabled" wire:target="statusPayment">Aprobar</button></li>
                                                    @endif
                                                    <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editPayment" wire:click="editPayment({{ $payment -> id }})">Editar</button></li>
                                                    <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="destroyPayment({{ $payment -> id }})" wire:loading.attr="disabled" wire:target="destroyPayment">Eliminar</button></li>
                                                </ul>
                                            </div>
                                        </td>--}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="py-5">
                            <img src="{{ asset('img/panel/think.svg') }}" width="128" class="d-block mx-auto mb-3">
                            <p class="text-center">No hay información aquí.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="info-tab-pane" role="tabpanel" aria-labelledby="info-tab" wire:ignore.self tabindex="0">
            <div class="border-dashed br-10 mb-4">
                <div class="border-bottom-dashed px-4 py-3 d-flex justify-content-between align-items-center">
                    <h2 class="fs-sm-18 m-0 fw-500">Información general</h2>

                    <button data-bs-toggle="modal" data-bs-target="#editInfoModal" class="btn btn-primary px-4">Editar</button>
                </div>
                <div class="p-4">
                    <table class="table table-borderless fs-sm-14">
                        <tbody>
                            <tr>
                                <td class="text-muted">Nombre</td>
                                <td>{{ $student -> name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Fecha de nacimiento</td>
                                <td>{{ $student -> student -> birthdate ? $student -> student -> birthdate -> format('d/m/Y') : '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Dirección</td>
                                <td>{{ $student -> student -> address }}, {{ $student -> student -> country }}.</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Teléfono</td>
                                <td>{{ $student -> student -> phone }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td>{{ $student -> email }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Profesión / ocupación / oficio</td>
                                <td>{{ $student -> student -> work }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Congregación</td>
                                <td>{{ $student -> student -> church }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">¿Es pastor?</td>
                                <td>{{ $student -> student -> pastor == 1 ? 'SI' : 'NO' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">¿Culminó el CEAP Inicial?</td>
                                <td>{{ $student -> student -> pastor == 1 ? 'SI' : 'NO' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="addPayment" tabindex="-1" aria-labelledby="addPaymentLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div wire:loading wire:target="addPayment" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header border-bottom-dashed p-4">
                    <h1 class="modal-title fs-sm-5" id="addPaymentLabel">Agregar pago</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <div class="mb-3">
                        <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                            <label class="fs-sm-14 text-muted">Email<span class="text-danger fs-sm-16">*</span></label><br>
                            <input class="border-0 bg-transparent w-100" type="text" wire:model.defer="addPaymentArray.payer_email" />
                        </div>

                        @error('addPaymentArray.payer_email')
                            <span class="fs-sm-12 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">Pasarela<span class="text-danger fs-sm-16">*</span></label><br>
                                <select class="border-0 bg-transparent w-100" wire:model.defer="addPaymentArray.gateway">
                                    <option value="">Elegir</option>
                                    <option value="MP">MercadoPago</option>
                                    <option value="SQ">SquareUp</option>
                                </select>
                            </div>

                            @error('addPaymentArray.gateway')
                                <span class="fs-sm-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                    <label class="fs-sm-14 text-muted">ID de pago<span class="text-danger fs-sm-16">*</span></label><br>
                                    <input class="border-0 bg-transparent w-100" type="text" wire:model.defer="addPaymentArray.payment_id" />
                                </div>

                                @error('addPaymentArray.payment_id')
                                    <span class="fs-sm-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                    <label class="fs-sm-14 text-muted">Monto<span class="text-danger fs-sm-16">*</span></label><br>
                                    <input class="border-0 bg-transparent w-100" type="number" wire:model.defer="addPaymentArray.amount" />
                                </div>

                                @error('addPaymentArray.amount')
                                    <span class="fs-sm-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                    <label class="fs-sm-14 text-muted">N° de cuota<span class="text-danger fs-sm-16">*</span></label><br>
                                    <input class="border-0 bg-transparent w-100" type="number" wire:model.defer="addPaymentArray.installment" />
                                </div>

                                @error('addPaymentArray.installment')
                                    <span class="fs-sm-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                        <label class="fs-sm-14 text-muted">Curso<span class="text-danger fs-sm-16">*</span></label><br>
                        <select class="border-0 bg-transparent w-100" wire:model.defer="addPaymentArray.course_id">
                            <option value="">Elegir</option>
                            @foreach ($courses as $crs)
                                <option value="{{ $crs -> id }}">{{ $crs -> name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('addPaymentArray.course_id')
                        <span class="fs-sm-12 text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="addPayment" wire:loading.attr="disabled" wire:target="addPayment">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="editPayment" tabindex="-1" aria-labelledby="editPaymentLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div wire:loading wire:target="editPayment" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header border-bottom-dashed p-4">
                    <h1 class="modal-title fs-sm-5" id="editPaymentLabel">Editar pago</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <div class="mb-3">
                        <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                            <label class="fs-sm-14 text-muted">Email<span class="text-danger fs-sm-16">*</span></label><br>
                            <input class="border-0 bg-transparent w-100" type="text" wire:model.defer="editPaymentArray.payer_email" />
                        </div>

                        @error('editPaymentArray.payer_email')
                            <span class="fs-sm-12 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">Pasarela<span class="text-danger fs-sm-16">*</span></label><br>
                                <select class="border-0 bg-transparent w-100" wire:model.defer="editPaymentArray.gateway">
                                    <option value="">Elegir</option>
                                    <option value="MP">MercadoPago</option>
                                    <option value="SQ">SquareUp</option>
                                </select>
                            </div>

                            @error('editPaymentArray.gateway')
                                <span class="fs-sm-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                    <label class="fs-sm-14 text-muted">ID de pago<span class="text-danger fs-sm-16">*</span></label><br>
                                    <input class="border-0 bg-transparent w-100" type="text" wire:model.defer="editPaymentArray.payment_id" />
                                </div>

                                @error('editPaymentArray.payment_id')
                                    <span class="fs-sm-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                    <label class="fs-sm-14 text-muted">Monto<span class="text-danger fs-sm-16">*</span></label><br>
                                    <input class="border-0 bg-transparent w-100" type="number" wire:model.defer="editPaymentArray.amount" />
                                </div>

                                @error('editPaymentArray.amount')
                                    <span class="fs-sm-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                    <label class="fs-sm-14 text-muted">N° de cuota<span class="text-danger fs-sm-16">*</span></label><br>
                                    <input class="border-0 bg-transparent w-100" type="number" wire:model.defer="editPaymentArray.installment" />
                                </div>

                                @error('editPaymentArray.installment')
                                    <span class="fs-sm-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                        <label class="fs-sm-14 text-muted">Curso<span class="text-danger fs-sm-16">*</span></label><br>
                        <select class="border-0 bg-transparent w-100" wire:model.defer="editPaymentArray.course_id">
                            <option value="">Elegir</option>
                            @foreach ($courses as $crs)
                                <option value="{{ $crs -> id }}">{{ $crs -> name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('editPaymentArray.course_id')
                        <span class="fs-sm-12 text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="updatePayment" wire:loading.attr="disabled" wire:target="editPayment, updatePayment">Actualizar</button>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div wire:loading wire:target="addCourse" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header border-bottom-dashed p-4">
                    <h1 class="modal-title fs-sm-5" id="addCourseLabel">Agregar curso</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                        <label class="fs-sm-14 text-muted">Curso<span class="text-danger fs-sm-16">*</span></label><br>
                        <select class="border-0 bg-transparent w-100" wire:model.defer="add_course_id">
                            <option value="">Elegir</option>
                            @foreach ($courses as $crs)
                                @if ( ! $student -> courses -> where('id', $crs -> id) -> first() )
                                    <option value="{{ $crs -> id }}">{{ $crs -> name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    @error('add_course_id')
                        <span class="fs-sm-12 text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="addCourse" wire:loading.attr="disabled" wire:target="editPayment, addCourse">Actualizar</button>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div wire:loading wire:target="update" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header border-bottom-dashed p-4">
                    <h1 class="modal-title fs-sm-5" id="editInfoModalLabel">Editar información</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <div class="row">
                        <div class="col-lg-8 mb-3">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">Nombre y apellido<span class="text-danger fs-sm-16">*</span></label><br>
                                <input class="border-0 bg-transparent w-100" type="text" wire:model.defer="userArray.name" autofocus placeholder="Nombre y Apellido" required />
                            </div>

                            @error('userArray.name')
                                <span class="fs-sm-14 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 mb-3">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">F. de nacimiento<span class="text-danger fs-sm-16">*</span></label><br>
                                <input type="text" class="border-0 bg-transparent w-100 datetimepicker" wire:model.defer="studentArray.birthdate" placeholder="F. de nacimiento" required>
                            </div>

                            @error('birthdate')
                                <span class="fs-sm-14 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">Dirección<span class="text-danger fs-sm-16">*</span></label><br>
                                <input type="text" class="border-0 bg-transparent w-100" wire:model.defer="studentArray.address" placeholder="Calle y nro." required>
                            </div>

                            @error('address')
                                <span class="fs-sm-14 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">País<span class="text-danger fs-sm-16">*</span></label><br>
                                <input type="text" class="border-0 bg-transparent w-100" wire:model.defer="studentArray.country" placeholder="País" required>
                            </div>

                            @error('country')
                                <span class="fs-sm-14 text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">Teléfono<span class="text-danger fs-sm-16">*</span></label><br>
                                <input type="number" class="border-0 bg-transparent w-100" wire:model.defer="studentArray.phone" placeholder="Teléfono" required>
                            </div>

                            @error('phone')
                                <span class="fs-sm-14 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                <label class="fs-sm-14 text-muted">E-mail<span class="text-danger fs-sm-16">*</span></label><br>
                                <input type="email" class="border-0 bg-transparent w-100" wire:model.defer="userArray.email" placeholder="Email" required>
                            </div>

                            @error('userArray.email')
                                <span class="fs-sm-14 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                            <label class="fs-sm-14 text-muted">Profesión / ocupación / oficio<span class="text-danger fs-sm-16">*</span></label><br>
                            <input type="text" class="border-0 bg-transparent w-100" wire:model.defer="studentArray.work" placeholder="Profesión / ocupación / oficio" required>
                        </div>

                        @error('work')
                            <span class="fs-sm-14 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                            <label class="fs-sm-14 text-muted">Congregación<span class="text-danger fs-sm-16">*</span></label><br>
                            <input type="text" class="border-0 bg-transparent w-100" wire:model.defer="studentArray.church" placeholder="Congregación" required>
                        </div>

                        @error('church')
                            <span class="fs-sm-14 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                ¿Es pastor?<span class="text-danger fs-sm-16">*</span><br>
                                <label class="me-3"><input type="radio" class="form-check-input" wire:model.defer="studentArray.pastor" value="1" required> SI</label>
                                <label><input type="radio" wire:model.defer="studentArray.pastor" class="form-check-input" value="2"> NO</label>

                                @error('pastor')
                                    <br><span class="fs-sm-14 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                ¿Culminó el CEAP Inicial?<span class="text-danger fs-sm-16">*</span><br>
                                <label class="me-3"><input type="radio" wire:model.defer="studentArray.ceap" class="form-check-input" value="1" required> SI</label>
                                <label><input type="radio" wire:model.defer="studentArray.ceap" class="form-check-input" value="2"> NO</label>

                                @error('ceap')
                                    <br><span class="fs-sm-14 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="update" wire:loading.attr="disabled" wire:target="update">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            flatpickr(".datetimepicker", {
                enableTime: false,
                dateFormat: "d/m/Y",
                defaultDate: '{{ $studentArray['birthdate'] ?? '01/01/1990'  }}',
                locale: "es",
            });
        </script>
    @endpush

</div>
