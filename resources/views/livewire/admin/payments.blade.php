<div class="px-5">
    <x-slot name="titlePage">- Pagos</x-slot>


    <div class="d-sm-flex justify-content-between align-items-center">
        <div>
            <h1 class="fs-sm-21 fw-700 mb-1">Pagos</h1>
            <h2 class="fs-sm-14 text-muted">Listado de pagos</h2>
        </div>
    </div>

    <div class="mt-4 d-flex align-items-center">
        <div class="border rounded-3 d-flex align-items-center overflow-hidden">
            <img src="{{ asset('img/icos/ico-search.svg') }}" width="24" class="ms-2">
            <input type="text" class="border-0 fs-sm-21 px-2 py-2" wire:model="search" placeholder="Buscar pago">
        </div>
    </div>

    @php
        $status_value = ['Pendiente', 'Aprobado'];
        $status_color = ['warning', 'success'];
    @endphp

    <div class="shadow p-4 rounded-4 mt-5">
        @if ( $payments -> count() )

            <table class="table table-borderless">
                <thead class="fs-sm-14 text-muted opacity-50 text-uppercase border-bottom">
                    <th class="ps-0">ID</th>
                    <th>Fecha</th>
                    <th>Alumno</th>
                    <th>Curso</th>
                    <th></th>
                    <th></th>
                    <th class="text-end">Monto</th>
                </thead>
                <tbody class="fs-sm-14">
                    @foreach ($payments as $payment)
                        <tr class="border-bottom-dashed align-middle">
                            <td class="py-3 ps-0">
                                {{ $payment -> payment_id }}
                            </td>
                            <td>
                                {{ $payment -> created_at -> format('d/m/Y') }}
                            </td>
                            <td>
                                {{ $payment -> user -> name }}<br>
                                <span class="fs-sm-12">{{ $payment -> payer_email }}</span>
                            </td>
                            <td>
                                {{ $payment -> course -> name }}
                            </td>
                            <td class="text-center">
                                <span class="badge text-bg-{{ $status_color[$payment -> status] }}">{{ $status_value[$payment -> status] }}</span>
                            </td>
                            <td>
                                <img src="{{ asset('img/icos/ico-' . $payment -> gateway . '.svg') }}" width="24" height="24">
                            </td>
                            <td class="text-end">
                                {{ $payment -> gateway == 'MP' ? 'AR$' : 'u$d' }} {{ number_format($payment -> amount, 2, ',', '.') }}
                            </td>
                            {{--<td class="text-end pe-0">
                                <div class="dropdown">
                                    <button class="bg-light rounded-circle border-0 p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{ asset('img/icos/ico-dots.svg') }}" width="16" height="16" class="d-block"></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('admin.students.show', $payment) }}">Ver información</a></li>
                                        @if ( $payment -> status )
                                            <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas deshabilitar al alumno?') || event.stopImmediatePropagation()" wire:click="status({{ $payment -> id }}, 0)" wire:loading.attr="disabled" wire:target="status()">Deshabilitar</button></li>
                                        @else
                                            <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas habilitar al alumno?') || event.stopImmediatePropagation()" wire:click="status({{ $payment -> id }}, 1)" wire:loading.attr="disabled" wire:target="status()">Habilitar</button></li>
                                        @endif
                                        <li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="destroy({{ $payment -> id }})" wire:loading.attr="disabled" wire:target="destroy({{ $payment -> id }})">Eliminar</button></li>
                                    </ul>
                                </div>
                            </td>--}}
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

                {{ $payments -> withQueryString() -> onEachSide(1) -> links() }}
            </div>

            

        @else

            <div class="py-5">
                <img src="{{ asset('img/panel/think.svg') }}" width="128" class="d-block mx-auto mb-3">
                <p class="text-center">No hay alumnos aquí.</p>
            </div>

        @endif  
    </div>
</div>
