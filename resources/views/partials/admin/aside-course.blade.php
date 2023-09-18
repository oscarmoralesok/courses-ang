<div class="menuEvent border-end position-fixed h-100 top-0 pt-5">

    @php
        $months = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', ' Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $status = ['Borrador', 'Activo', 'Programado'];
        $color = ['warning', 'success', 'primary'];
    @endphp

    <div class="px-4 border-bottom">
        <div class="ratio ratio-1x1 rounded-5 bg-img mb-3" style="background-image: url({{ asset($course -> cover) }}); width: 104px;"></div>
        <span class="badge text-bg-{{ $color[$course -> status] }}">{{ $status[$course -> status] }}</span>
        <h1 class="fs-sm-32 fw-700 lh-1 mb-3 mt-2">
            {{ $course -> name }}
        </h1>
        {{--<p class="text-secondary d-flex align-items-center">
            <img src="{{ asset('img/icos/ico-calendar.svg') }}" width="16" class="me-2 f-gray">
            {{ $months[$course -> start_date -> format('n')] }}
            {{ $course -> start_date -> format('d') }},
            {{ $course -> start_date -> format('Y') }}
            -
            {{ $course -> start_date -> format('H:i') }} hs.
        </p>--}}
    </div>

    <div class="p-4 border-bottom">
        <a class="d-block text-secondary fs-sm-14 text-uppercase mb-2 py-2 px-3 rounded-3 {{ (request()->is('admin/curso/*/modulos')) ? 'bg-primary text-white' : '' }}" href="{{ route('admin.courses.show', $course) }}">Módulos</a>
        <a class="d-block text-secondary fs-sm-14 text-uppercase mb-2 py-2 px-3 rounded-3 {{ (request()->is('admin/curso/*/editar')) ? 'bg-primary text-white' : '' }}" href="{{ route('admin.courses.edit', $course) }}">Editar curso</a>
        <a class="d-block text-secondary fs-sm-14 text-uppercase mb-2 py-2 px-3 rounded-3 {{ (request()->is('admin/curso/*/profesores')) ? 'bg-primary text-white' : '' }}" href="{{ route('admin.courses.teachers', $course) }}">Profesores</a>
    </div>
    <div class="p-4 border-bottom">
        <a class="d-block text-secondary fs-sm-14 text-uppercase mb-2 py-2 px-3 rounded-3 {{ (request()->is('admin/curso/*/alumnos')) ? 'bg-primary text-white' : '' }}" href="{{ route('admin.courses.students', $course) }}">Alumnos</a>
    </div>
</div>