<div>
    <footer class="bg-black py-sm-5 pb-5 text-white">
        <div class="container pt-5 px-4 px-sm-3">
            <div class="row justify-content-between mb-5">
                <div class="col-sm-3 mb-4 mb-sm-0">
                    <img src="{{ asset('img/logo-global-w.svg') }}" width="60">
                    <p class="fs-sm-14 text-muted mt-3 mb-3">El Centro de Entrenamiento de Alta Productividad (CEAP) es una unidad funcional dentro de un organismo multifacético que es el Cuerpo de Cristo.</p>

                    <div class="d-flex align-items-center text-muted mb-2"><img src="{{ asset('img/icos/ico-phone.svg') }}" width="16" class="f-invert opacity-50 me-2"> +54 9 11 6123-5011</div>
                    <div class="d-flex align-items-center text-muted"><img src="{{ asset('img/icos/ico-email2.svg') }}" width="16" class="f-invert opacity-50 me-2"> info@ceapavanzado.com</div>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-3 mb-4 mb-sm-0">
                            <h4 class="fs-sm-18 fw-700 mb-4">Página</h4>

                            <ul class="list-unstyled">
                                <li class="mb-2"><a class="text-muted" href="{{ url('/#about') }}">Sobre nosotros</a></li>
                                <li class="mb-2"><a class="text-muted" href="{{ url('/#modalities') }}">Modalidades</a></li>
                                <li class="mb-2"><a class="text-muted" href="{{ url('/#team') }}">Equipo</a></li>
                                <li class="mb-2"><a class="text-muted" href="{{ url('/#contact') }}">Contactanos</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-3 mb-4 mb-sm-0">
                            <h4 class="fs-sm-18 fw-700 mb-4">Usuarios</h4>

                            <ul class="list-unstyled">
                                @auth()
                                    <li class="mb-2"><a class="text-muted" href="{{ route('panel.dashboard') }}">Panel de control</a></li>
                                @else
                                    <li class="mb-2"><a class="text-muted" href="{{ route('register') }}">Registrarse</a></li>
                                    <li class="mb-2"><a class="text-muted" href="{{ route('login') }}">Acceder</a></li>
                                @endauth
                                <li class="mb-2"><a class="text-muted" href="{{ route('policy.show') }}">Privacidad</a></li>
                                <li class="mb-2"><a class="text-muted" href="{{ route('terms.show') }}">Términos</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <h5 class="fs-sm-18 fw-700 mb-4">Seguinos en</h5>
                            <a class="mx-2" href="#" target="_blank"><img src="{{ asset('img/icos/ico-fb.svg') }}" width="24" height="24"></a>
                            <a class="mx-2" href="#" target="_blank"><img src="{{ asset('img/icos/ico-in.svg') }}" width="24" height="24"></a>
                            <a class="mx-2" href="#" target="_blank"><img src="{{ asset('img/icos/ico-tt.svg') }}" width="24" height="24"></a>
                            <a class="mx-2" href="#" target="_blank"><img src="{{ asset('img/icos/ico-ig.svg') }}" width="24" height="24"></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-5 mt-5 border-top border-dark text-center text-muted fs-sm-13">
                Copyright © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
            </div>
        </div>
    </footer>
</div>