<div class="row">
    <div class="col-sm-4 mb-4 mb-sm-0 col-md-12 col-lg-4">
        <div class="bg-light shadow-sm rounded-4 p-sm-5 p-4 h-100 d-flex flex-column justify-content-between">
            <div>
                <h4 class="text-center fs-sm-32 fs-28 mb-5">Membresía Full</h4>
                <h5 class="text-center text-primary fs-sm-18 mb-4">Beneficios</h5>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2">Acceso a los cursos nuevos</li>
                    <li class="mb-2">Acceso a la biblioteca con mas de 25 cursos disponibles por un año.</li>
                    <li class="mb-2">Certificado digital.</li>
                    <li class="mb-2">Material del curso en formato audiovisual.</li>
                    <li class="mb-2">Material del curso en formato PDF.</li>
                    <li class="mb-2">Bibliografía adicional.</li>
                    <li>Masterclass en vivo.</li>
                </ul>
            </div>

            <div class="px-3">
            <span class="d-block border border-dark rounded-3 text-center p-3 mb-2">-</span>
                <button class="btn btn-dark py-3 fw-600 w-100 text-uppercase" data-bs-toggle="modal" data-bs-target="#membershipModal" wire:click="$set('type', 2)">MUY PRONTO</button>
            </div>
        </div>
    </div>
    <div class="col-sm-4 mb-4 mb-sm-0 col-md-12 col-lg-4">
        <div class="bg-light shadow-sm rounded-4 p-sm-5 p-4 h-100 d-flex flex-column justify-content-between">
            <div>
                <h4 class="text-center fs-sm-32 fs-28 mb-5">Membresía Basic</h4>
                <h5 class="text-center text-primary fs-sm-18 mb-4">Beneficios</h5>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2">Acceso a los cursos nuevos</li>
                    <li class="mb-2">Acceso a la biblioteca de un curso por mes.</li>
                    <li class="mb-2">Certificado digital.</li>
                    <li class="mb-2">Material del curso en formato audiovisual.</li>
                    <li class="mb-2">Material del curso en formato PDF.</li>
                    <li class="mb-2 text-secondary"><del>Bibliografía adicional.</del></li>
                    <li class="text-secondary"><del>Masterclass en vivo.</del></li>
                </ul>
            </div>

            <div class="px-3">
                <span class="d-block border border-dark rounded-3 text-center p-3 mb-2">-</span>
                <button class="btn btn-dark py-3 fw-600 w-100 text-uppercase" data-bs-toggle="modal" data-bs-target="#membershipModal" wire:click="$set('type', 1)">MUY PRONTO</button>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-md-12 col-lg-4">
        <div class="bg-light shadow-sm rounded-4 p-sm-5 p-4 h-100 d-flex flex-column justify-content-between">
            <div>
                <h4 class="text-center fs-sm-32 fs-28 mb-5">Curso único</h4>
                <h5 class="text-center text-primary fs-sm-18 mb-4">Beneficios</h5>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2">Accede a los contenidos del curso elegido.</li>
                    <li class="mb-2">Certificado digital.</li>
                    <li class="mb-2">Material del curso en formato audiovisual.</li>
                    <li class="mb-2">Material del curso en formato PDF.</li>
                    <li class="mb-2 text-secondary"><del>Bibliografía adicional.</del></li>
                    <li class="text-secondary"><del>Masterclass en vivo.</del></li>
                </ul>
            </div>

            <div class="px-3">
                <span class="d-block border border-dark rounded-3 text-center p-3 mb-2">Escoja un curso</span>

                <a href="#courses" class="btn btn-primary py-3 fw-600 w-100 text-uppercase">Comience hoy mismo</a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="membershipModal" tabindex="-1" aria-labelledby="membershipModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" wire:ignore.self>
            <div class="modal-content">
                <div class="modal-header border-0 pt-4 pb-0 px-4 mb-4 align-items-center">
                    <h1 class="fs-sm-18 fw-600 m-0">Membresía</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    @if ( ! $suscribed )
                        @if ( ! Auth::check() )
                            <ul class="nav nav-pills mb-3" id="myTab" role="tablist" wire:ignore>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="login-tab" onclick="$('.modal-dialog').removeClass('modal-lg')" data-bs-toggle="tab" data-bs-target="#login-tab-pane" type="button" role="tab" aria-controls="login-tab-pane" aria-selected="true">Acceder</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="register-tab" onclick="$('.modal-dialog').addClass('modal-lg')" data-bs-toggle="tab" data-bs-target="#register-tab-pane" type="button" role="tab" aria-controls="register-tab-pane" aria-selected="false">Registrarse</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="login-tab-pane" role="tabpanel" aria-labelledby="login-tab" tabindex="0" wire:ignore.self>
                                    <form wire:submit.prevent="login">
                                        <div class="mb-4">
                                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-fill">
                                                        <label class="fs-sm-14 text-muted">{{ __('Email') }}</label><br>
                                                        <input id="email" class="form-control border-0 bg-transparent w-100 @error('email') is-invalid @enderror" type="email" wire:model.defer="email" value="{{ old('email') }}" required autofocus placeholder="usuario@mail.com" />
                                                    </div>

                                                    <img src="{{ asset('img/icos/ico-email.svg') }}" width="24" class="opacity-50">
                                                </div>
                                            </div>

                                            @error('email')
                                                <span class="fs-sm-14 text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-fill">
                                                        <label class="fs-sm-14 text-muted">{{ __('Password') }}</label><br>
                                                        <input id="password" class="form-control border-0 bg-transparent w-100 @error('password') is-invalid @enderror" type="password" wire:model.defer="password" placeholder="****" required />
                                                    </div>

                                                    <img src="{{ asset('img/icos/ico-pass.svg') }}" width="24" class="opacity-50">
                                                </div>
                                            </div>

                                            @error('password')
                                                <span class="fs-sm-14 text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-4 fs-sm-14">
                                            @if (Route::has('password.request'))
                                                <a class="text-muted" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                                            @endif

                                            <button type="submit" class="btn btn-primary px-5 rounded-3 py-2">{{ __('Log in') }}</button>
                                        </div>

                                        @if ( $error )
                                            <span class="text-danger mt-2">{{ $error }}</span>
                                        @endif
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="register-tab-pane" role="tabpanel" aria-labelledby="register-tab" tabindex="0" wire:ignore.self>
                                    <form wire:submit.prevent="register">
                                        <div class="row">
                                            <div class="col-lg-8 mb-3">
                                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                    <label class="fs-sm-14 text-muted">Nombre y Apellido<span class="text-danger fs-sm-16">*</span></label><br>
                                                    <input class="border-0 bg-transparent w-100 form-control @error('userArray.name') is-invalid @enderror" type="text" wire:model.defer="userArray.name" autofocus placeholder="Nombre y Apellido" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                    <label class="fs-sm-14 text-muted">F. de nacimiento<span class="text-danger fs-sm-16">*</span></label><br>
                                                    <input type="text" class="border-0 bg-transparent w-100 form-control @error('studentArray.birthdate') is-invalid @enderror datetimepicker" wire:model.defer="studentArray.birthdate" placeholder="F. de nacimiento" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                    <label class="fs-sm-14 text-muted">Dirección<span class="text-danger fs-sm-16">*</span></label><br>
                                                    <input type="text" class="border-0 bg-transparent w-100 form-control @error('studentArray.address') is-invalid @enderror" wire:model.defer="studentArray.address" placeholder="Calle y nro." required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                    <label class="fs-sm-14 text-muted">País<span class="text-danger fs-sm-16">*</span></label><br>
                                                    <input type="text" class="border-0 bg-transparent w-100 form-control @error('studentArray.country') is-invalid @enderror" wire:model.defer="studentArray.country" placeholder="País" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                    <label class="fs-sm-14 text-muted">Teléfono<span class="text-danger fs-sm-16">*</span></label><br>
                                                    <input type="number" class="border-0 bg-transparent w-100 form-control @error('studentArray.phone') is-invalid @enderror" wire:model.defer="studentArray.phone" placeholder="Teléfono" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                    <label class="fs-sm-14 text-muted">E-mail<span class="text-danger fs-sm-16">*</span></label><br>
                                                    <input type="email" class="border-0 bg-transparent w-100 form-control @error('userArray.email') is-invalid @enderror" wire:model.defer="userArray.email" placeholder="Email" required>
                                                </div>

                                                @error('userArray.email')
                                                    <span class="fs-sm-14 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                <label class="fs-sm-14 text-muted">Profesión / ocupación / oficio<span class="text-danger fs-sm-16">*</span></label><br>
                                                <input type="text" class="border-0 bg-transparent w-100 form-control @error('studentArray.work') is-invalid @enderror" wire:model.defer="studentArray.work" placeholder="Profesión / ocupación / oficio" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                <label class="fs-sm-14 text-muted">Congregación<span class="text-danger fs-sm-16">*</span></label><br>
                                                <input type="text" class="border-0 bg-transparent w-100 form-control @error('studentArray.church') is-invalid @enderror" wire:model.defer="studentArray.church" placeholder="Congregación" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-4">
                                                    <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-fill">
                                                                <label class="fs-sm-14 text-muted">{{ __('Password') }}<span class="text-danger fs-sm-16">*</span></label><br>
                                                                <input id="password" class="border-0 bg-transparent w-100 form-control @error('userArray.password') is-invalid @enderror" type="password" wire:model.defer="userArray.password" placeholder="****" required />
                                                            </div>

                                                            <img src="{{ asset('img/icos/ico-pass.svg') }}" width="24" class="opacity-50">
                                                        </div>
                                                    </div>

                                                    @error('password')
                                                        <span class="fs-sm-14 text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="mb-4">
                                                    <div class="bg-secondary bg-opacity-10 px-4 py-2 rounded-4">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-fill">
                                                                <label class="fs-sm-14 text-muted">{{ __('Confirm Password') }}<span class="text-danger fs-sm-16">*</span></label><br>
                                                                <input id="password_confirmation" class="border-0 bg-transparent w-100 form-control @error('password_confirmation') is-invalid @enderror" type="password" wire:model.defer="password_confirmation" placeholder="****" required />
                                                            </div>

                                                            <img src="{{ asset('img/icos/ico-pass.svg') }}" width="24" class="opacity-50">
                                                        </div>
                                                    </div>

                                                    @error('password_confirmation')
                                                        <span class="fs-sm-14 text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary px-5 rounded-3 py-2">{{ __('Register') }}</button>
                                    </form>
                                </div>
                            </div>
                        @else

                            <p>Estas por suscribirte nuestra <strong>Membresía {{ $type == 1 ? 'Basic' : 'Full' }}</strong>. Debitaremos de tu tarjeta $ {{ number_format($type == 1 ? '100' : '500', 2, ',', '.') }} todos los meses mientras estés suscripto.</p>

                            <div id="paymentSquare" wire:ignore>
                                {{--<form id="">--}}
                                    <div id="card-container"></div>
                                    <button id="card-button" class="btn btn-success px-4 text-white" type="button">Suscribirse</button>
                                {{--</form>--}}
                                <div id="payment-status-container"></div>
                            </div>

                        @endif
                    @else
                        <h5 class="text-center">¡Felicitaciones!</h5>
                        <p class="text-center">Ya estás suscripto a nuestra membresía. Comienza a disfrutar de los beneficios que tienes desde este momento.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            flatpickr(".datetimepicker", {
                enableTime: false,
                dateFormat: "d/m/Y",
                defaultDate: '{{ old('birthdate', '01/01/1990')  }}',
                locale: "es",
            });

            window.livewire.on('registered', () => {
                $('.modal-dialog').removeClass('modal-lg')
            })

            window.livewire.on('rejected', () => {
                $('.btnsubmit').after('<div class="bg-danger p-3 rounded-3 text-white fs-sm-14 mt-3">Ocurrió un problema al intentar realizar tu pago. Controla los datos ingresados o intenta con otra tarjeta.</div>');
            });


            function resizeIframe(obj) {
                setTimeout(function () {
                    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
                }, 1000);
            }
        </script>

        {{-- <script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script> --}}
        <script type="text/javascript" src="https://web.squarecdn.com/v1/square.js"></script>

        <script>

            const appId = '{{ config('services.square.id') }}';
            const locationId = '{{ config('services.square.location') }}';

            async function initializeCard(payments) {
                const card = await payments.card();
                await card.attach('#card-container');
                return card;
            }

            async function createPayment(token) {
                const body = JSON.stringify({
                    locationId,
                    sourceId: token,
                    payment_method: document.querySelector('input[name="payment_mode"]:checked').value
                });

                const paymentResponse = await fetch('/process_payment_membership', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body,
                });

                if (paymentResponse.ok) {
                    return paymentResponse.json();
                }

                const errorBody = await paymentResponse.text();
                throw new Error(errorBody);
            }

            async function tokenize(paymentMethod) {
                const tokenResult = await paymentMethod.tokenize();
                if (tokenResult.status === 'OK') {
                    return tokenResult.token;
                } else {
                    let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
                    if (tokenResult.errors) {
                        errorMessage += ` and errors: ${JSON.stringify(
                            tokenResult.errors
                            )}`;
                    }

                    throw new Error(errorMessage);
                }
            }

            // status is either SUCCESS or FAILURE;
            function displayPaymentResults(status) {
                const statusContainer = document.getElementById('payment-status-container');
                if (status === 'SUCCESS') {
                    statusContainer.classList.remove('is-failure');
                    statusContainer.classList.add('is-success');
                } else {
                    statusContainer.classList.remove('is-success');
                    statusContainer.classList.add('is-failure');
                }

                statusContainer.style.visibility = 'visible';
            }

            @if ( Auth::check() )

                document.addEventListener('DOMContentLoaded', async function () {
                    if (!window.Square) {
                        throw new Error('Square.js failed to load properly');
                    }

                    const payments = window.Square.payments(appId, locationId);
                    let card;
                    try {
                        card = await initializeCard(payments);
                    } catch (e) {
                        console.error('Initializing Card failed', e);
                        return;
                    }

                    async function handlePaymentMethodSubmission(event, paymentMethod) {
                        event.preventDefault();

                        $('#payment-status-container').css('visibility', 'hidden');
                        $('.alert').remove()

                        try {
                            // disable the submit button as we await tokenization and make a payment request.
                            cardButton.disabled = true;
                            $('#card-button').html('Enviando...');

                            const token = await tokenize(paymentMethod);
                            const paymentResults = await createPayment(token);

                            //displayPaymentResults('SUCCESS');

                            if ( paymentResults.state == 'error' ) {
                                console.log(paymentResults)
                                $('#card-button').html('Abonar');
                                cardButton.disabled = false;

                                if ( paymentResults.message != '[object Object]' ) {
                                    $('#paymentSquare').after('<div class="alert alert-danger mt-3 alert-dismissible fade show w-100">' + paymentResults.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                                } else {
                                    $('#paymentSquare').after('<div class="alert alert-danger mt-3 alert-dismissible fade show w-100">El pago no pudo ser procesado. Intenta con otra tarjeta, o comunícate con el banco.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                                }

                                
                            } else {
                                window.location.href = '{{ route('panel.courses') }}';
                            }
                        } catch (e) {
                            $('#card-button').html('Abonar');
                            cardButton.disabled = false;
                            displayPaymentResults('FAILURE');
                            console.error(e.message);
                        }
                    }

                    const cardButton = document.getElementById('card-button');
                    cardButton.addEventListener('click', async function (event) {
                        await handlePaymentMethodSubmission(event, card);
                    });
                });
            @endif

            Livewire.on('renderSquare', () => {
                async function loadSquare () {
                    if (!window.Square) {
                        throw new Error('Square.js failed to load properly');
                    }

                    const payments = window.Square.payments(appId, locationId);
                    let card;
                    try {
                        card = await initializeCard(payments);
                    } catch (e) {
                        console.error('Initializing Card failed', e);
                        return;
                    }

                    async function handlePaymentMethodSubmission(event, paymentMethod) {
                        event.preventDefault();

                        $('#payment-status-container').css('visibility', 'hidden');
                        $('.alert').remove()

                        try {
                            // disable the submit button as we await tokenization and make a payment request.
                            cardButton.disabled = true;
                            $('#card-button').html('Enviando...');

                            const token = await tokenize(paymentMethod);
                            const paymentResults = await createPayment(token);

                            //displayPaymentResults('SUCCESS');

                            if ( paymentResults.state == 'error' ) {
                                console.log(paymentResults)
                                $('#card-button').html('Abonar');
                                cardButton.disabled = false;

                                if ( paymentResults.message != '[object Object]' ) {
                                    $('#paymentSquare').after('<div class="alert alert-danger mt-3 alert-dismissible fade show w-100">' + paymentResults.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                                } else {
                                    $('#paymentSquare').after('<div class="alert alert-danger mt-3 alert-dismissible fade show w-100">El pago no pudo ser procesado. Intenta con otra tarjeta, o comunícate con el banco.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                                }

                                
                            } else {
                                window.location.href = '{{ route('panel.courses') }}';
                            }
                        } catch (e) {
                            $('#card-button').html('Abonar');
                            cardButton.disabled = false;
                            displayPaymentResults('FAILURE');
                            console.error(e.message);
                        }
                    }

                    const cardButton = document.getElementById('card-button');
                    cardButton.addEventListener('click', async function (event) {
                        await handlePaymentMethodSubmission(event, card);
                    });
                };

                loadSquare()
            })
        </script>
    @endpush

</div>