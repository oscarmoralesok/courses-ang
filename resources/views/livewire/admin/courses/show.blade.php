<div>
	<x-slot name="titlePage">- Informanción de Curso</x-slot>

	@include('partials.admin.aside-course')

	<div class="contentEvent">
		<div class="px-5">
			<div class="d-sm-flex justify-content-between align-items-center mb-4">
				<div>
					<h1 class="fs-sm-21 fw-700 mb-1">Cursos</h1>
					<h2 class="fs-sm-14 text-muted">Informanción de Curso</h2>
				</div>
				<a href="{{ route('admin.courses.index') }}" class="btn btn-light border py-3 px-4 lh-1 rounded-4">Volver al listado</a>
			</div>

			@php
				$status_value = ['Inactivo', 'Activo'];
				$status_color = ['warning', 'success'];
			@endphp

			@if (session('status'))
				<div class="mb-4 bg-success text-white fs-sm-14 rounded-3 p-3">
					{{ session('status') }}
				</div>
			@endif

			<div class="border-dashed br-10 mb-4">
				<div class="border-bottom-dashed px-4 py-3 d-flex justify-content-between align-items-center">
					<h2 class="fs-sm-18 m-0 fw-500">Módulos</h2>

					<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModule">Agregar módulo</button>
				</div>
				<div class="p-4">
					@if ( $course -> modules -> count() )
						<div class="accordion accordion-flush mb-4" id="accordionFlushExample">
							@foreach ($course -> modules -> sortBy('number') as $module)
								<div class="accordion-item">
									<h2 class="accordion-header fs-sm-16 d-flex align-items-center justify-content-between py-2" id="flush-heading-{{ $module -> id }}">
										<span class="flex-fill">{{ $module -> number }} - {{ $module -> name }}</span>

										<div class="d-flex text-nowrap">
											<button class="btn btn-light tooltipToggle" title="Editar módulo" data-bs-toggle="modal" data-bs-target="#editModule" wire:click="editModule('{{ $module -> slug }}')"><img src="{{ asset('img/icos/ico-edit.svg') }}" width="16"></button>

											<a class="btn btn-light ms-2 tooltipToggle" title="Agregar lección" href="{{ route('admin.courses.lessons.create', [$course, $module]) }}"><img src="{{ asset('img/icos/ico-document-2.svg') }}" width="16"></a>

											<button class="btn btn-light ms-2 tooltipToggle" title="Eliminar módulo" onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="destroyModule('{{ $module -> slug }}')" wire:loading.attr="disabled" wire:target="destroyModule('{{ $module -> slug }}')"><img src="{{ asset('img/icos/ico-delete.svg') }}" width="16"></button>

											<button class="accordion-button w-auto collapsed bg-light p-2 rounded-3 ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{ $module -> id }}" aria-expanded="false" aria-controls="flush-collapse-{{ $module -> id }}"></button>
										</div>
									</h2>
									<div id="flush-collapse-{{ $module -> id }}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{ $module -> id }}" data-bs-parent="#accordionFlushExample">
										<div class="accordion-body">
											<div class="table-responsive">
												<table class="table table-borderless">
													<thead>
														<tr class="border-bottom-dashed fs-sm-14 fw-500 text-uppercase text-muted">
															<th class="ps-0">Lección</th>
															<th>Duración</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														@foreach ($module -> lessons -> sortBy('number') as $lesson)
															<tr class="border-bottom-dashed fs-sm-14">
																<td class="py-3 ps-0">
																	{{ $lesson -> number }} - 
																	{{ $lesson -> title }}
																</td>
																<td>{{ $lesson -> duration }}</td>
																<td class="text-end pe-0">
																	<a class="btn btn-light tooltipToggle" title="Editar lección" href="{{ route('admin.courses.lessons.edit', [$course, $module, $lesson]) }}"><img src="{{ asset('img/icos/ico-edit.svg') }}" width="16"></a>
																	<button class="btn btn-light ms-2 tooltipToggle" title="Eliminar lección" onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="destroyModule('{{ $lesson -> slug }}')" wire:loading.attr="disabled" wire:target="destroyLesson('{{ $lesson -> slug }}')"><img src="{{ asset('img/icos/ico-delete.svg') }}" width="16"></button>
																</td>
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


		<div wire:ignore.self class="modal fade" id="addModule" tabindex="-1" aria-labelledby="addModuleLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content rounded-4 border-0">
					<div wire:loading wire:target="addModule" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
						<div class="position-absolute top-50 start-50 translate-middle">
							<div class="spinner-border text-primary" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
						</div>
					</div>
					<div class="modal-header border-bottom-dashed p-4">
						<h1 class="fs-sm-16" id="addModuleLabel">Agregar módulo</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body p-4">
						<div class="mb-3">
							<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
								<label class="fs-sm-14 text-muted">Nombre</label>
								<input class="border-0 bg-transparent w-100" type="text" wire:model="addModuleArray.name" placeholder="Nombre" />
							</div>

							@error('addModuleArray.name')
								<span class="fs-sm-12 text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="row">
							<div class="col-sm-6 d-flex align-items-center">
								<div class="mb-3">
									<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
										<label class="fs-sm-14 text-muted">Orden</label>
										<input class="border-0 bg-transparent w-100 fs-sm-21" placeholder="1" type="number" wire:model.defer="addModuleArray.number">
									</div>

									@error('addModuleArray.number')
										<span class="fs-sm-12 text-danger">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-sm-6">
								<div class="mb-3">
									<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
										<label class="fs-sm-14 text-muted">F. de Publicación</label>
										<input class="border-0 bg-transparent w-100 datetimepicker" type="text" readonly wire:model.defer="addModuleArray.posted_at">
									</div>

									@error('addModuleArray.posted_at')
										<span class="fs-sm-12 text-danger">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
					</div>
						
					<div class="modal-footer pt-0 border-0">
						<button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="addModule" wire:loading.attr="disabled" wire:target="addModule">Guardar</button>
					</div>
				</div>
			</div>
		</div>


		<div wire:ignore.self class="modal fade" id="editModule" tabindex="-1" aria-labelledby="editModuleLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content rounded-4 border-0">
					<div wire:loading wire:target="editModule, updateModule" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
						<div class="position-absolute top-50 start-50 translate-middle">
							<div class="spinner-border text-primary" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
						</div>
					</div>
					<div class="modal-header border-bottom-dashed p-4">
						<h1 class="fs-sm-16" id="editModuleLabel">Editar módulo</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body p-4">
						<div class="mb-3">
							<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
								<label class="fs-sm-14 text-muted">Nombre</label>
								<input class="border-0 bg-transparent w-100" type="text" wire:model="editModuleArray.name" placeholder="Nombre" />
							</div>

							@error('editModuleArray.name')
								<span class="fs-sm-12 text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="row">
							<div class="col-sm-6 d-flex align-items-center">
								<div class="mb-3">
									<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
										<label class="fs-sm-14 text-muted">Orden</label>
										<input class="border-0 bg-transparent w-100 fs-sm-21" placeholder="1" type="number" wire:model.defer="editModuleArray.number">
									</div>

									@error('editModuleArray.number')
										<span class="fs-sm-12 text-danger">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-sm-6">
								<div class="mb-3">
									<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
										<label class="fs-sm-14 text-muted">F. de Publicación</label>
										<input class="border-0 bg-transparent w-100 datetimepicker2" type="text" readonly wire:model.defer="editModuleArray.posted_at">
									</div>

									@error('editModuleArray.posted_at')
										<span class="fs-sm-12 text-danger">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
					</div>
						
					<div class="modal-footer pt-0 border-0">
						<button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="updateModule" wire:loading.attr="disabled" wire:target="editModule, updateModule">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
		<script type="text/javascript">
			flatpickr(".datetimepicker", {
				enableTime: false,
				dateFormat: "d/m/Y",
				locale: "es",
			});

			window.livewire.on('setPosted', () => {
				flatpickr(".datetimepicker2", {
					enableTime: false,
					dateFormat: "d/m/Y",
					locale: "es",
					defaultDate: "{{ $editModuleArray ? $editModuleArray['posted_at'] : '' }}",
				});
			})
		</script>
	@endpush
</div>
