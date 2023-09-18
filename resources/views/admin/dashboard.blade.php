<x-app-layout>
	<x-slot name="titlePage">- Dashboard</x-slot>

	<h1 class="fs-sm-21 fw-700 mb-1">Dashboard</h1>
	<h2 class="fs-sm-14 text-muted">Panel de control</h2>

	<div class="row mt-5">
		<div class="col-sm-6">
			<div class="shadow p-4 rounded-4 d-flex">
				<img src="{{ asset('img/icos/ico-students.svg') }}" width="48" class="f-gray">

				<div class="ps-4">
					<span class="fs-sm-48 fw-300 d-block lh-1">{{ $students -> count() }}</span>
					<span class="fs-sm-14 text-uppercase">Estudiantes</span>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="shadow p-4 rounded-4 d-flex">
				<img src="{{ asset('img/icos/ico-document.svg') }}" width="48" class="f-gray">

				<div class="ps-4">
					<span class="fs-sm-48 fw-300 d-block lh-1">{{ $courses -> count() }}</span>
					<span class="fs-sm-14 text-uppercase">Cursos</span>
				</div>
			</div>
		</div>


		@php
			$status_value = ['Pendiente', 'Aprobado'];
			$status_color = ['warning', 'success'];
		@endphp

		<div class="col-sm-6">
			<h3 class="mt-5 mb-4 fs-sm-21 fw-700">Últimos pagos</h3>
			<table class="table table-borderless">
				<tbody>
					@foreach ($lastPayments as $payment)
						<tr class="border-bottom-dashed align-middle">
							<td class="text-center">
								<span class="bg-{{ $status_color[$payment -> status] }} ratio ratio-1x1 rounded-circle d-block" style="width: 8px;"></span>
							</td>
							<td class="py-3 lh-sm">
								<strong>$ {{ number_format($payment -> amount, 2, ',', '.') }}</strong><br>
								<span class="fs-sm-14 text-muted">{{ $payment -> course ? $payment -> course -> name : '' }}</span>
							</td>
							<td>
								<img src="{{ asset('img/icos/ico-' . $payment -> gateway . '.svg') }}" width="24" height="24">
							</td>
							<td>
								{{ $payment -> user -> name }}<br>
								<span class="fs-sm-12">{{ $payment -> payer_email }}</span>
							</td>
							<td class="text-end">
								{{ $payment -> created_at -> format('j M Y') }}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</x-app-layout>