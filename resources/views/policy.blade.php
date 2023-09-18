<x-web-layout>
    <x-slot name="titlePage">- Política de privacidad</x-slot>

    <div class="bg-primary text-white pt-5">
        <div class="py-5">
            <div class="container py-5">
                <span class="text-uppercase fs-sm-14 text-white-50">Legal</span>
                <h1 class="fs-sm-56 m-0 fw-600">Política de privacidad</h1>
            </div>
        </div>
    </div>

    <div class="container py-5">
        {!! $policy !!}
    </div>
</x-web-layout>
