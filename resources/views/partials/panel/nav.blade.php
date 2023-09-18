<nav class="position-fixed top-0 start-0 h-100 d-flex flex-column justify-content-between menu-nav">
	<img src="{{ asset('img/logo.svg') }}" width="56" class="d-sm-block d-none mx-auto mt-4">

	<ul class="list-unstyled text-center navigation m-0">
		<li class="position-relative d-inline-block d-sm-block">
			<a href="{{ route('panel.dashboard') }}" class="d-inline-block my-2 p-3 rounded-circle {{ request()->is('panel/dashboard') ? 'active' : '' }}"><img src="{{ asset('img/icos/ico-dashboard.svg') }}" width="24" height="24"></a>
			<span class="position-absolute bg-white shadow py-2 px-3 rounded-3 top-50 translate-middle-y text-nowrap d-none" style="left: 110px">Dashboard</span>
		</li>
		<li class="position-relative d-inline-block d-sm-block">
			<a href="{{ route('panel.courses') }}" class="d-inline-block my-2 p-3 rounded-circle {{ request()->is('panel/cursos*') ? 'active' : '' }}"><img src="{{ asset('img/icos/ico-document.svg') }}" width="24" height="24"></a>
			<span class="position-absolute bg-white shadow py-2 px-3 rounded-3 top-50 translate-middle-y text-nowrap d-none" style="left: 110px">Mis cursos</span>
		</li>
		{{-- <li class="position-relative d-inline-block d-sm-block">
			<a href="#" class="d-inline-block my-2 p-3 rounded-circle {{ request()->is('panel/configuracion*') ? 'active' : '' }}"><img src="{{ asset('img/icos/ico-settings.svg') }}" width="24" height="24"></a>
			<span class="position-absolute bg-white shadow py-2 px-3 rounded-3 top-50 translate-middle-y text-nowrap d-none" style="left: 110px">Configuración</span>
		</li> --}}
	</ul>

	<div></div>
	<ul class="list-unstyled text-center p-2 rounded-pill m-4 bg-white d-none">
		<li><a href="#" class="d-inline-block d-block py-2 rounded-circle overflow-hidden bg-secondary"><img src="{{ asset('img/icos/ico-sun.svg') }}" width="20" height="20" class="d-block mx-auto f-brightness"></a></li>
		<li><a href="#" class="d-inline-block d-block py-2 rounded-circle overflow-hidden"><img src="{{ asset('img/icos/ico-moon.svg') }}" width="20" height="20" class="d-block mx-auto"></a></li>
	</ul>
</nav>