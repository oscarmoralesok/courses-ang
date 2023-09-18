<x-web-layout>
	<section class="pt-5">
		<div class="container py-5">
			<div class="row pt-5 gx-sm-5">
				<div class="col-sm-2">
					<div class="ratio ratio-1x1 rounded-4 bg-img" style="background-image: url('{{ asset($course -> cover) }}')"></div>
				</div>
				<div class="col-sm-7">
					<h1 class="pt-4 fs-sm-36 fw-700">{{ $course -> name }}</h1>
					<p class="fs-sm-16 text-muted fw-300">{{ $course -> excerpt }}</p>
				</div>
				<div class="col-sm-3 d-flex align-items-center justify-content-center">
					@if ( $course -> suscription_enable )
						<livewire:web.suscription :course="$course" />
						
					@else
						<button class="btn btn-secondary px-5 py-3 rounded-4 disabled" disabled>Inscripción cerrada</button>
					@endif
				</div>
			</div> 
		</div>

		<div class="bg-light py-5">
			<div class="container">
				<div class="row gx-sm-5">
					<div class="col-sm-9">
						<nav>
							<div class="nav nav-tabs mb-4 border-0" id="nav-tab" role="tablist" >
								<button class="nav-link active border-0 rounded-3" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" type="button" role="tab" aria-controls="nav-about" aria-selected="true">Sobre el curso</button>
								<button class="nav-link  border-0 rounded-3" id="nav-teachers-tab" data-bs-toggle="tab" data-bs-target="#nav-teachers" type="button" role="tab" aria-controls="nav-teachers" aria-selected="false">Profesores</button>
								<button class="nav-link  border-0 rounded-3" id="nav-modules-tab" data-bs-toggle="tab" data-bs-target="#nav-modules" type="button" role="tab" aria-controls="nav-modules" aria-selected="false">Módulos</button>
							</div>
						</nav>

						<div class="tab-content" id="nav-tabContent">
  							<div class="tab-pane fade show active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab" tabindex="0">
								<div class="bg-white rounded-4 p-sm-5 p-4">
									<h3 class="fs-sm-21 fw-700 mb-4">Sobre el curso</h3>
									<div class="lh-lg mb-5">{!! $course -> description !!}</div>
								</div>
							</div>
							<div class="tab-pane fade" id="nav-teachers" role="tabpanel" aria-labelledby="nav-teachers-tab" tabindex="0">
								<div class="bg-white rounded-4 p-sm-5 p-4">
									<h3 class="fs-sm-18 fw-700 mb-4">Profesor/es</h3>
									<div class="row">
										@foreach ($course -> teachers as $teacher)
											<div class="col-sm-3 text-center">
												<div class="ratio ratio-1x1 mx-auto mb-3 rounded-circle bg-img" style="background-image: url('{{ asset($teacher -> photo) }}'); width:96px"></div>
												<h4 class="fs-sm-16 fw-600 mb-2">{{ $teacher -> name }}</h4>
												<span class="fs-sm-13 d-block lh-sm">{{ $teacher -> subtitle }}</span>
											</div>
										@endforeach
									</div>
								</div>
							</div>
  							<div class="tab-pane fade" id="nav-modules" role="tabpanel" aria-labelledby="nav-modules-tab" tabindex="0">
  								<div class="bg-white rounded-4 p-sm-5 p-4">
	  								@if ( $course -> modules -> count() )
										<div class="accordion accordion-flush rounded-4 mb-4" id="accordionFlushExample">
											@foreach ($course -> modules -> sortBy('number') as $module)
												<div class="accordion-item">
													<h2 class="accordion-header fs-sm-16 d-flex align-items-center justify-content-between py-2" id="flush-heading-{{ $module -> id }}">
														<button class="accordion-button collapsed p-2 w-100" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{ $module -> id }}" aria-expanded="false" aria-controls="flush-collapse-{{ $module -> id }}">
															<span class="flex-fill">{{ $module -> name }}</span>
														</button>
													</h2>
													<div id="flush-collapse-{{ $module -> id }}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{ $module -> id }}" data-bs-parent="#accordionFlushExample">
														<div class="accordion-body bg-light">
															<div class="table-responsive">
																<table class="table table-borderless mb-0">
																	<thead>
																		<tr class="border-bottom-dashed fs-sm-14 fw-500 text-uppercase text-muted">
																			<th class="ps-0">Lección</th>
																			<th class="text-end">Duración</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach ($module -> lessons -> sortBy('number') as $lesson)
																			<tr class="border-bottom-dashed fs-sm-14">
																				<td class="py-3 ps-0">{{ $lesson -> title }}</td>
																				<td class="text-end">{{ $lesson -> duration }}</td>
																			</tr>
																		@endforeach
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>
											@endforeach
										</div>
									@else
										<p class="text-center">No hay información aquí.</p>
									@endif
  								</div>
  							</div>
						</div>
					</div>
					<div class="col-sm-3 mt-4 mt-sm-0">
						<div class="bg-white p-sm-5 p-4 rounded-4 mb-5">
							<div class="d-flex justify-content-between align-items-center mb-3">
								<div class="d-flex align-items-center">
									<img src="{{ asset('img/web/ico-3.svg') }}" width="20" height="20" class="me-2">
									Alumnos
								</div>
								{{ $course -> users -> count() }}
							</div>
							<div class="d-flex justify-content-between align-items-center mb-3">
								<div class="d-flex align-items-center">
									<img src="{{ asset('img/icos/ico-dollar.svg') }}" width="20" height="20" class="me-2">
									Precio
								</div>
								u$d {{ $course -> price_usd }}
							</div>
							<div class="d-flex justify-content-between align-items-center mb-3">
								<div class="d-flex align-items-center">
									<img src="{{ asset('img/web/ico-4.svg') }}" width="20" height="20" class="me-2">
									Lecciones
								</div>
								{{ $course -> lessons -> count() }}
							</div>
							<div class="d-flex justify-content-between align-items-center mb-3">
								<div class="d-flex align-items-center">
									<img src="{{ asset('img/web/ico-11.svg') }}" width="20" height="20" class="me-2">
									Incripción
								</div>
								{!! $course -> suscription_enable ? '<span class="badge bg-success">Activa</span>' : '<span class="badge bg-secondary">Cerrada</span>' !!}
							</div>
						</div>

						<h4 class="fs-sm-16 fw-600 mb-4">Cursos relacionados</h4>
						<ul class="list-unstyled mb-5">
							@foreach ($related_courses as $rc)
								<li class="mb-2 border-bottom-dashed pb-2"><a class="text-muted" href="{{ route('web.course', $rc) }}">{{ $rc -> name }}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
</x-web-layout>