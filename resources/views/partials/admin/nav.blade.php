<nav class="position-fixed top-0 start-0 h-100 d-flex flex-column justify-content-between menu-nav">
	<img src="{{ asset('img/logo.svg') }}" width="56" class="d-block mx-auto mt-4">

	<ul class="list-unstyled text-center navigation">
		<li class="position-relative">
			<a href="{{ route('admin.dashboard') }}" class="d-inline-block my-2 p-3 rounded-circle {{ request()->is('admin/dashboard') ? 'active' : '' }}"><img src="{{ asset('img/icos/ico-dashboard.svg') }}" width="24" height="24"></a>
			<span class="position-absolute bg-white shadow py-2 px-3 rounded-3 top-50 translate-middle-y text-nowrap d-none" style="left: 110px">Dashboard</span>
		</li>
		<li class="position-relative">
			<a href="{{ route('admin.students.index') }}" class="d-inline-block my-2 p-3 rounded-circle {{ request()->is('admin/alumnos*') ? 'active' : '' }}"><img src="{{ asset('img/icos/ico-students.svg') }}" width="24" height="24"></a>
			<span class="position-absolute bg-white shadow py-2 px-3 rounded-3 top-50 translate-middle-y text-nowrap d-none" style="left: 110px">Alumnos</span>
		</li>
		<li class="position-relative">
			<a href="{{ route('admin.courses.index') }}" class="d-inline-block my-2 p-3 rounded-circle {{ request()->is('admin/curso*') ? 'active' : '' }}"><img src="{{ asset('img/icos/ico-document.svg') }}" width="24" height="24"></a>
			<span class="position-absolute bg-white shadow py-2 px-3 rounded-3 top-50 translate-middle-y text-nowrap d-none" style="left: 110px">Curso</span>
		</li>
		<li class="position-relative">
			<a href="{{ route('admin.payments.index') }}" class="d-inline-block my-2 p-3 rounded-circle {{ request()->is('admin/pagos*') ? 'active' : '' }}"><img src="{{ asset('img/icos/ico-wallet.svg') }}" width="24" height="24"></a>
			<span class="position-absolute bg-white shadow py-2 px-3 rounded-3 top-50 translate-middle-y text-nowrap d-none" style="left: 110px">Pagos</span>
		</li>
		<li class="position-relative">
			<a href="{{ route('admin.teachers.index') }}" class="d-inline-block my-2 p-3 rounded-circle {{ request()->is('admin/profesores*') ? 'active' : '' }}"><img src="{{ asset('img/icos/ico-bag.svg') }}" width="24" height="24"></a>
			<span class="position-absolute bg-white shadow py-2 px-3 rounded-3 top-50 translate-middle-y text-nowrap d-none" style="left: 110px">Profesores</span>
		</li>
		<li class="position-relative">
			<a href="{{ route('admin.users.index') }}" class="d-inline-block my-2 p-3 rounded-circle {{ request()->is('admin/usuarios*') ? 'active' : '' }}"><img src="{{ asset('img/icos/ico-key.svg') }}" width="24" height="24"></a>
			<span class="position-absolute bg-white shadow py-2 px-3 rounded-3 top-50 translate-middle-y text-nowrap d-none" style="left: 110px">Usuarios</span>
		</li>
	</ul>

	<div></div>
	{{-- <ul class="list-unstyled text-center p-2 rounded-pill m-4 bg-white">
		<li><a href="#" class="d-inline-block d-block py-2 rounded-circle overflow-hidden bg-secondary"><img src="{{ asset('img/icos/ico-sun.svg') }}" width="20" height="20" class="d-block mx-auto f-brightness"></a></li>
		<li><a href="#" class="d-inline-block d-block py-2 rounded-circle overflow-hidden"><img src="{{ asset('img/icos/ico-moon.svg') }}" width="20" height="20" class="d-block mx-auto"></a></li>
	</ul> --}}
</nav>