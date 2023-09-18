<div class="px-5">
	<x-slot name="titlePage">- Usuarios</x-slot>

	<div class="d-sm-flex justify-content-between align-items-center">
		<div>
			<h1 class="fs-sm-21 fw-700 mb-1">Usuarios</h1>
			<h2 class="fs-sm-14 text-muted">Crear, editar y eliminar usuarios</h2>
		</div>
	</div>

	<div class="row justify-content-between">
		<div class="col-sm-3">
			<div class="border-dashed p-4 rounded-4 mt-5 position-relative">
				<div wire:loading wire:target="save, photo" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
					<div class="position-absolute top-50 start-50 translate-middle">
						<div class="spinner-border text-primary" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
					</div>
				</div>

				<h3 class="fs-sm-18 mb-3">Crear usuario</h3>

				<div class="mb-3">
					<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
						<label class="fs-sm-14 text-muted">Nombre<span class="text-danger fs-sm-16">*</span></label><br>
						<input class="border-0 bg-transparent w-100" type="text" wire:model.defer="createArray.name" />
					</div>

					@error('createArray.name')
						<span class="fs-sm-12 text-danger">{{ $message }}</span>
					@enderror
				</div>
				<div class="mb-3">
					<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
						<label class="fs-sm-14 text-muted">Email<span class="text-danger fs-sm-16">*</span></label><br>
						<input class="border-0 bg-transparent w-100" type="text" wire:model.defer="createArray.email" />
					</div>

					@error('createArray.email')
						<span class="fs-sm-12 text-danger">{{ $message }}</span>
					@enderror
				</div>

				<button class="btn btn-primary py-2 px-4 rounded-3" wire:click="save" wire:loading.attr="disabled" wire:target="save, photo">Guardar</button>
			</div>
		</div>

		<div class="col-sm-8">
			<div class="shadow p-4 rounded-4 mt-5">
				@if ( $users -> count() )

					<table class="table table-borderless">
						<thead class="fs-sm-14 text-muted opacity-50 text-uppercase border-bottom">
							<th class="ps-0">Nombre</th>
							<th>Email</th>
							<th></th>
						</thead>
						<tbody class="fs-sm-14">
							@foreach ($users as $user)
								<tr class="border-bottom-dashed align-middle">
									<td class="py-3">
										<div class="d-flex align-items-center">
											@if ( $user -> profile_photo_path ) 
												@php
													$photo = asset($user -> profile_photo_path);
												@endphp
											@elseif ( $user -> socialProfiles -> count() )
												@php
													$photo = $user -> socialProfiles -> first() -> social_avatar;
												@endphp
											@else
												@php
													$photo = $user -> profile_photo_url;
												@endphp
											@endif
											<div class="ratio ratio-1x1 rounded-4 bg-img me-3" style="background-image: url('{{ $photo }}'); width: 48px;"></div>
											<span class="fs-sm-16 fw-600">{{ $user -> name }}</span>
										</div>
									</td>
									<td>{{ $user -> email }}</td>
									<td class="text-end pe-0">
										<div class="dropdown">
											<button class="bg-light rounded-circle border-0 p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{ asset('img/icos/ico-dots.svg') }}" width="16" height="16" class="d-block"></button>
											<ul class="dropdown-menu dropdown-menu-end">
												<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editUser" wire:click="edit({{ $user -> id }})">Editar</a></li>
												<li><button class="dropdown-item" onclick="confirm('¿Seguro que deseas eliminar este registro?') || event.stopImmediatePropagation()" wire:click="destroy({{ $user -> id }})" wire:loading.attr="disabled" wire:target="destroy({{ $user -> id }})">Eliminar</button></li>
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

						{{ $users -> withQueryString() -> onEachSide(1) -> links() }}
					</div>

				@else

					<div class="py-5">
						<img src="{{ asset('img/panel/think.svg') }}" width="128" class="d-block mx-auto mb-3">
						<p class="text-center">No hay usuarios aquí.</p>
					</div>

				@endif  
			</div>
		</div>
	</div>


	<div wire:ignore.self class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content rounded-4 border-0">
				<div wire:loading wire:target="edit, udpate" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
					<div class="position-absolute top-50 start-50 translate-middle">
						<div class="spinner-border text-primary" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
					</div>
				</div>
				<div class="modal-header border-bottom-dashed p-4">
					<h1 class="modal-title fs-sm-5" id="showTicketsLabel">Editar usuario</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body p-4">

					<div class="mb-3">
						<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
							<label class="fs-sm-14 text-muted">Nombre<span class="text-danger fs-sm-16">*</span></label><br>
							<input class="border-0 bg-transparent w-100" type="text" wire:model.defer="editArray.name" />
						</div>

						@error('editArray.name')
							<span class="fs-sm-12 text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="mb-3">
						<div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
							<label class="fs-sm-14 text-muted">Email<span class="text-danger fs-sm-16">*</span></label><br>
							<input class="border-0 bg-transparent w-100" type="text" wire:model.defer="editArray.email" />
						</div>

						@error('editArray.email')
							<span class="fs-sm-12 text-danger">{{ $message }}</span>
						@enderror
					</div>

				</div>

				<div class="modal-footer pt-0 border-0">
					<button type="button" class="btn btn-secondary py-3 lh-1 px-4 rounded-4" data-bs-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="update" wire:loading.attr="disabled" wire:target="edit, update">Actualizar</button>
				</div>
			</div>
		</div>
	</div>

</div>
