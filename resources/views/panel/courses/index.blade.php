<x-panel-layout>
	<x-slot name="titlePage">- Mis cursos</x-slot>

    <h1 class="fs-sm-21 fw-700 mb-1">Mis cusros</h1>
    <h2 class="fs-sm-14 text-muted">Cursos a los que te has inscripto</h2>

	<div class="row gx-sm-5 mt-5">
		@foreach ($courses as $course)
			<div class="col-sm-4 mb-4">
				<div class="shadow rounded-4 overflow-hidden mb-4 mb-sm-0">
					<div class="ratio ratio-16x9 bg-img" style="background-image: url('{{ asset($course -> cover) }}')"></div>
					<div class="p-4">
						<h2 class="fs-sm-21 fw-700">{{ $course -> name }}</h2>
						<p class="mb-4">{{ $course -> excerpt }}</p>
						<a class="btn btn-primary py-3 text-uppercase fw-600 rounded-4 w-100" href="{{ route('panel.courses.show', $course) }}">Acceder</a>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</x-panel-layout>