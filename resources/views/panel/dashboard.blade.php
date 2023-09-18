<x-panel-layout>
	<x-slot name="titlePage">- Dashboard</x-slot>

    <h1 class="fs-sm-21 fw-700 mb-1">Dashboard</h1>
    <h2 class="fs-sm-14 text-muted">Bienvenido al panel</h2>


	<div class="row gx-sm-5 mt-5">
		<h3 class="fs-sm-21 fw-600 mb-3">Cursos disponibles</h3>
		@foreach ($courses as $course)
			@if ( ! Auth::user() -> courses() -> wherePivot('course_id', $course -> id) -> first() )
				<div class="col-sm-4 mb-4">
					<div class="shadow rounded-4 overflow-hidden">
						<div class="ratio ratio-16x9 bg-img" style="background-image: url('{{ asset($course -> cover) }}')"></div>
						<div class="p-4">
							<h2 class="fs-sm-21 fw-700">{{ $course -> name }}</h2>
							<p class="mb-4">{{ $course -> excerpt }}</p>
							{{-- <button data-bs-toggle="modal" data-bs-target="#suscribeModal" class="btn btn-primary py-3 text-uppercase fw-600 rounded-4 w-100">Inscripción</button> --}}
							<a class="btn btn-primary py-3 text-uppercase fw-600 rounded-4 w-100" href="{{ route('web.course', $course) }}">Ver información</a>
						</div>
					</div>
				</div>
			@endif
		@endforeach
	</div>
</x-panel-layout>