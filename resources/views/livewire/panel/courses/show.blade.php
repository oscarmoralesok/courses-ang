<div>
	<div class="menuEvent border-light pt-sm-5 overflow-auto">
		<div class="px-sm-4 border-bottom border-light">
			<div class="d-flex mb-3 align-items-start">
				<div class="ratio ratio-1x1 rounded-4 bg-img me-3" style="background-image: url({{ asset($course -> cover) }}); width: 64px;"></div>
				<h1 class="fs-sm-16 fw-700 lh-1 mb-3 mt-2">{{ $course -> name }}</h1>
			</div>
		</div>

		<div class="p-sm-4 py-4">
			<div class="overflow-hidden read-more h-80 fs-sm-14 text-black-50 mb-3">
				{!! $course -> description !!}
			</div>
			<a class="btn btn-link border btn-sm" onclick="$('.read-more').toggleClass('h-80')">Leer más</a>
		</div>

		<div class="p-sm-4 mb-4 mb-sm-0">
			<button class="btn btn-primary d-block d-sm-none w-100" onclick="$('.modules').slideToggle()">Mostrar módulos</button>

			<div class="accordion modules accordion-flush" id="accordionFlushExample">
				@foreach ($course -> modules -> sortBy('number') as $mdl)
					<div class="accordion-item mb-3 bg-light rounded-3">
						<h2 class="accordion-header" id="flush-heading{{ $mdl -> id }}">
							<button  wire:ignore.self class="accordion-button d-flex align-items-center @if ( isset( $module ) && $module -> slug == $mdl -> slug ) @else collapsed @endif p-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $mdl -> id }}" aria-expanded="@if ( isset( $module ) && $module -> slug == $mdl -> slug ) true @else false @endif" aria-controls="flush-collapse{{ $mdl -> id }}">
								<div ><span class="bg-primary d-block py-2 w-35 text-center me-2 rounded-3 text-white lh-1">{{ $mdl -> number }}</span></div>
								<div class="flex-fill pe-3">
									{{ $mdl -> name }}
								</div>
							</button>
						</h2>
						<div id="flush-collapse{{ $mdl -> id }}" wire:ignore.self class="accordion-collapse collapse @if ( isset( $module ) && $module -> slug == $mdl -> slug ) show @endif" aria-labelledby="flush-heading{{ $mdl -> id }}" data-bs-parent="#accordionFlushExample">
							<div class="accordion-body p-3">

								@if ( date('Y-m-d H:i') < $mdl -> posted_at )

									<p class="text-center">Fecha de publicación: {{ $mdl -> posted_at -> format('d/m/Y') }}</p>

								@else
									<ul class="list-unstyled">

										{{-- LISTADO DE LECCIONES --}}
										@foreach ($mdl -> lessons -> sortBy('number') as $lssn)
											<li class="border-bottom py-3 fs-sm-14">
												<label class="d-flex justify-content-between @if ( isset( $lesson ) && $lesson -> slug == $lssn -> slug ) fw-600 @endif text-dark align-items-center" style="cursor: pointer;">
													<div>
														<input class="float-start" type="radio" name="leccion" value="{{ $lssn -> slug }}" wire:model="leccion" style="height: 1px; opacity: 0; width: 1px;">
														{{ $lssn -> title }}
													</div>

													<div class="ps-2">
														@if ( Auth::user() -> completeLessons -> where('lesson_id', $lssn -> id) -> first() )
															<img src="{{ asset('img/icos/ico-check.svg') }}" width="24">
														@else
															<img src="{{ asset('img/icos/ico-check.svg') }}" class="f-gray" width="24">
														@endif
													</div>
												</label>
											</li>
										@endforeach

										{{-- EXAM --}}
										@if ( $mdl -> exam_status )
											<li class="border-bottom py-3">
												<div class="d-flex justify-content-between align-items-center">
													<button class="border-0 bg-transparent p-0 m-0 flex-fill text-start"
													@if ( ! Auth::user() -> examResults -> where('module_id', $mdl -> id) -> first() )
														onclick="confirm('¿Seguro que deseas realizar el examen? Recuerda que tienes solo una oportunidad para realizarlo. Una vez que comiences deberás finalizarlo.') || event.stopImmediatePropagation()" 
													@endif
													 wire:click="loadExam('{{ $mdl -> slug }}')" wire:loading.attr="loadExam" wire:target="loadExam">Examen
														@if ( Auth::user() -> examResults -> where('module_id', $mdl -> id) -> first() )
															({{ Auth::user() -> examResults -> where('module_id', $mdl -> id) -> first() -> score }} %)
														@endif
													</button>

													@if ( Auth::user() -> examResults -> where('module_id', $mdl -> id) -> first() )
														<img src="{{ asset('img/icos/ico-check.svg') }}" width="24">
													@else
														<img src="{{ asset('img/icos/ico-check.svg') }}" class="f-gray" width="24">
													@endif
												</div>
											</li>
										@endif
									</ul>
								@endif
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>

	<div class="contentEvent">
		<div class="px-sm-5 position-relative">
			<div wire:loading wire:target="leccion, loadExam" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
				<div class="position-absolute top-50 start-50 translate-middle">
					<div class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
				</div>
			</div>

			@if ( $lesson )
				@php $nroVideo = 0; @endphp
				<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true" data-interval="false">
					@if ( $lesson -> videos -> count() > 1 )
						<div class="carousel-indicators">
							@for ($i = 0; $i < $lesson -> videos -> count(); $i++)
								<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $i }}" @if ( ! $i ) class="active" aria-current="true" @endif aria-label="Slide {{ $i + 1 }}"></button>
							@endfor
						</div>
					@endif
					<div class="carousel-inner">
						@foreach ($lesson -> videos as $video)
							@php
								$nroVideo++;
								$codevideo = explode('/', $video -> url)
							@endphp
							<div class="carousel-item {{ $nroVideo == 1 ? 'active' : '' }}">
								<div class="ratio ratio-16x9 rounded-4 overflow-hidden">
									<iframe src="https://player.vimeo.com/video/{{ end($codevideo) }}?h=a3bf0affdd&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
								</div>
							</div>
						@endforeach
					</div>
				</div>

				<div class="py-5 row gx-sm-5">
					<div class="col-sm-8">
						<h1 class="fs-sm-24 fw-700 mb-4">{{ $lesson -> title }}</h1>
						{!! $lesson -> description !!}
					</div>
					<div class="col-sm-4">

						@if ( $completeLesson )
							<span class="mb-4 btn btn-success w-100 py-3 rounded-4">Clase finalizada</span>
						@else
							<button wire:click="lessonEnd" wire:loading.attr="disabled" wire:target="lessonEnd" class="mb-4 btn btn-primary w-100 py-3 rounded-4">Finalizar clase <img src="{{ asset('img/icos/ico-check.svg') }}" width="16" class="ms-2" style="margin-top: -2px"></button>
						@endif

						@if ( $lesson -> archives -> count() )
							<h4 class="fs-sm-18 mb-3">Material de descarga</h4>

							@foreach ($lesson -> archives -> sortBy('order') as $archive)
								<a class="bg-light rounded-3 p-3 text-dark fs-sm-14 d-flex justify-content-between align-items-center mb-3" href="{{ asset($archive -> path) }}" target="_blank">
									<span>{{ $archive -> name }}</span>
									<img src="{{ asset('img/icos/ico-download.svg') }}" width="36" class="ms-2">
								</a>
							@endforeach
						@endif
					</div>
				</div>

			@elseif ( $exam )

				<h3 class="fs-sm-21 fw-700 mb-4">Exámen de módulo "{{ $module_exam -> name }}"</h3>

				@if ( $showExam )
					<div class="mb-5 bg-warning p-3 rounded-3 text-center">Has ingresado a realizar el examen del curso. A partir de este momento no puedes salir del sitio hasta finalizarlo. En caso de que tengas algún inconveniente de conexión, problemas con el ordenador o dispositivo móbil, recuerda sacar captura de pantalla o fotos y escribir <a href="mailto:cursos@allnewglobal.com">cursos@allnewglobal.com</a> para que analicemos el inconveniente y así poder darte una nueva oportunidad.</div>

					<div class="listanswers">
						@foreach ($questions as $question)
							<div class="mb-4">
								<h4 class="fs-sm-18 fw-700">{{ $question -> question }}</h4>
								@foreach ($question -> answers as $answer)
									<label class="d-flex align-items-center p-3 rounded-3 mb-2 question-{{ $question -> id }}"
										onclick="$('.question-{{ $question -> id }}').removeClass('active'); $(this).addClass('active');">
										<img src="{{ asset('img/icos/ico-checkbox-unchecked.svg') }}" class="checkbox unchecked me-2" width="21">
										<img src="{{ asset('img/icos/ico-checkbox-checked.svg') }}" class="checkbox checked f-invert me-2" width="21">
										<input type="radio" name="question-{{ $question -> id }}" wire:model.defer="question.{{ $question -> id }}" value="{{ $answer -> id }}" class="opacity-0 float-start" style="height: 1px; width: 1px;">{{ $answer -> answer }}
									</label>
								@endforeach
							</div>
						@endforeach
					</div>

					<button class="btn btn-success py-3 px-4 rounded-4" wire:click="sendAnswers" wire:loading.attr="disabled" wire:target="sendAnswers">Enviar respuestas</button>
				@endif

				@if ( $showResult )
					<div class="listanswersResult">
						@foreach ($questions as $question)
							<div class="mb-4">
								<h4 class="fs-sm-18 fw-700">{{ $question -> question }}</h4>
								@foreach ($question -> answers as $answer)
									@php
										$user_answer = Auth::user() -> responses -> where('question_id', $question -> id) -> first() ? Auth::user() -> responses -> where('question_id', $question -> id) -> first() -> answer_id : 0;
										$question_answer = $question -> answers -> where('correct', 1) -> first() -> id;
									@endphp
									<label class="d-flex align-items-center p-3 rounded-3 mb-2 question-{{ $question -> id }}
										@if ( $answer -> id == $question_answer && $user_answer == $question_answer ) active @endif
										@if ( $answer -> id == $question_answer && $user_answer != $question_answer ) text-success @endif
										@if ( $answer -> id != $question_answer && $answer -> id == $user_answer ) bg-danger text-white @endif
										">
										@if ( $question -> answers -> where('correct', 1) -> first() -> id == $answer -> id )
											<img src="{{ asset('img/icos/ico-checkbox-checked.svg') }}" class="checkbox checked @if ( $answer -> id == $question_answer && $user_answer == $question_answer ) f-invert @endif me-2" width="21">
										@else
											<img src="{{ asset('img/icos/ico-checkbox-bad.svg') }}" class="checkbox unchecked @if ( $answer -> id != $question_answer && $answer -> id == $user_answer ) f-invert @endif me-2" width="21">
										@endif
										{{ $answer -> answer }}
									</label>
								@endforeach
							</div>
						@endforeach
					</div>
				@endif

			@else
				<p class="text-center mt-5"><img src="{{ asset('img/panel/form.svg') }}" width="64"></p>
				<p class="text-center py-5">Elige tu lección para comenzar.</p>
			@endif
		</div>
	</div>



	@if ( $country == 'Argentina' )
		<div wire:ignore.self class="modal fade" id="paymentMp" tabindex="-1" aria-labelledby="paymentMpLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content rounded-4 border-0">
					<div wire:loading wire:target="loadPayment, savePaymentMP" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
						<div class="position-absolute top-50 start-50 translate-middle">
							<div class="spinner-border text-primary" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
						</div>
					</div>
					<div class="modal-header border-bottom-dashed p-4">
						<h1 class="modal-title fs-sm-5" id="paymentMpLabel">Abonar</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body p-4">
						<div class="d-flex align-items-center justify-content-between fs-sm-12 pb-4">
							<h4 class="fs-sm-18 fw-700 m-0">Realizar pago</h4>
							<div>
								Development by <img src="{{ asset('img/web/mercado-pago.svg') }}" height="20" class="ms-2">
							</div>
						</div>
						<div class="mb-3">
							<div class="form-floating">
								<input class="form-control" type="text" wire:model.defer="buyer.card_number" placeholder="Número de tarjeta" autocomplete="off" name="cstCCNumber" id="cstCCNumber" onkeyup="cc_format('cstCCNumber','cstCCardType');">
								<label>Número de tarjeta<span class="text-danger fs-sm-16">*</span></label>
							</div>

							@error('buyer.card_number')
								<span class="text-danger fs-sm-12">{{ $message }}</span>
							@enderror
						</div>

						<div class="row">
							<div class="col-sm-6 mb-3">
								<div class="form-floating" wire:ignore>
									<input class="form-control" maxlength='5' wire:model.defer="buyer.expiration" placeholder="MM/YY" placeholder="Vencimiento" type="text" autocomplete="off" onkeyup="formatString(event);">
									<label>Vencimiento (dd/yy)<span class="text-danger fs-sm-16">*</span></label>
								</div>

								@error('buyer.expiration')
									<span class="text-danger fs-sm-12">{{ $message }}</span>
								@enderror
							</div>
							<div class="col-sm-6 mb-3">
								<div class="form-floating">
									<input class="form-control" type="password" wire:model.defer="buyer.cvv" maxlength="4" placeholder="Cod. Seguridad" autocomplete="off">
									<label>Cod. Seguridad<span class="text-danger fs-sm-16">*</span></label>
								</div>

								@error('buyer.cvv')
									<span class="text-danger fs-sm-12">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="mb-3">
							<div class="form-floating">
								<input class="form-control" type="text" wire:model.defer="buyer.card_name" placeholder="Nombre en la tarjeta">
								<label>Nombre en la tarjeta<span class="text-danger fs-sm-16">*</span></label>
							</div>

							@error('buyer.card_name')
								<span class="text-danger fs-sm-12">{{ $message }}</span>
							@enderror
						</div>

						<div class="row">
							<div class="col-sm-6 mb-3 mb-sm-0">
								<div class="form-floating mb-3">
									<select class="form-select" wire:model.defer="buyer.id">
										<option value="">Identificación</option>
										<option value="DNI">DNI</option>
										<option value="CI">CI</option>
										<option value="LC">LC</option>
										<option value="LE">LE</option>
										<option value="Otros">Otros</option>
									</select>
									<label>Identificación<span class="text-danger fs-sm-16">*</span></label>
								</div>

								@error('buyer.id')
									<span class="text-danger fs-sm-12">{{ $message }}</span>
								@enderror
							</div>
							<div class="col-sm-6">
								<div class="form-floating mb-3">
									<input class="form-control" type="number" wire:model.defer="buyer.id_number" placeholder="Nro. Documento">
									<label>Nro. Documento<span class="text-danger fs-sm-16">*</span></label>
								</div>

								@error('buyer.id_number')
									<span class="text-danger fs-sm-12">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="mb-3">
							<div class="form-floating">
								<input class="form-control" type="email" wire:model.defer="buyer.email" placeholder="Email">
								<label>Email<span class="text-danger fs-sm-16">*</span></label>
							</div>

							@error('buyer.email')
								<span class="text-danger fs-sm-12">{{ $message }}</span>
							@enderror
						</div>
					</div>
						
					<div class="modal-footer pt-0 border-0">
						<button type="button" class="btn btn-primary py-3 lh-1 px-4 rounded-4" wire:click="savePaymentMP" wire:loading.attr="disabled" wire:target="loadPayment, savePaymentMP">Abonar</button>
					</div>
				</div>
			</div>
		</div>
	@else
		<div wire:ignore.self class="modal fade" id="paymentSq" tabindex="-1" aria-labelledby="paymentSqLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content rounded-4 border-0">
					<div wire:loading wire:target="paymentSq, savePaymentMP" class="position-absolute w-100 h-100 top-0 start-0 bg-light" style="--bs-bg-opacity: 0.9; z-index: 2;">
						<div class="position-absolute top-50 start-50 translate-middle">
							<div class="spinner-border text-primary" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
						</div>
					</div>
					<div class="modal-header border-bottom-dashed p-4">
						<h1 class="modal-title fs-sm-5" id="paymentMpLabel">Abonar</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body p-4">
						<div id="paymentSquare" wire:ignore>
							{{--<form id="">--}}
								<div id="card-container"></div>
								<button id="card-button" class="btn btn-success px-4 text-white" type="button">Abonar</button>
							{{--</form>--}}
							<div id="payment-status-container"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif


	@push('scripts')

		@if ( $country == 'Argentina' )

			<script type="text/javascript">
				function formatString(e) {
					var inputChar = String.fromCharCode(event.keyCode);
					var code = event.keyCode;
					var allowedKeys = [8];
					if (allowedKeys.indexOf(code) !== -1) {
						return;
					}

					event.target.value = event.target.value.replace(
						/^([1-9]\/|[2-9])$/g, '0$1/' // 3 > 03/
					).replace(
						/^(0[1-9]|1[0-2])$/g, '$1/' // 11 > 11/
					).replace(
						/^([0-1])([3-9])$/g, '0$1/$2' // 13 > 01/3
					).replace(
						/^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2' // 141 > 01/41
					).replace(
						/^([0]+)\/|[0]+$/g, '0' // 0/ > 0 and 00 > 0
					).replace(
						/[^\d\/]|^[\/]*$/g, '' // To allow only digits and `/`
					).replace(
						/\/\//g, '/' // Prevent entering more than 1 `/`
					);
				}

				function cc_format(ccid,ctid) {
					// supports Amex, Master Card, Visa, and Discover
					// parameter 1 ccid= id of credit card number field
					// parameter 2 ctid= id of credit card type field

					var ccNumString = document.getElementById(ccid).value;
					ccNumString = ccNumString.replace(/[^0-9]/g, '');
					// mc, starts with - 51 to 55
					// v, starts with - 4
					// dsc, starts with 6011, 622126-622925, 644-649, 65
					// amex, starts with 34 or 37
					var typeCheck = ccNumString.substring(0, 2);
					var cType = '';
					var block1 = '';
					var block2 = '';
					var block3 = '';
					var block4 = '';
					var formatted = '';

					if  (typeCheck.length == 2) {
						typeCheck = parseInt(typeCheck);
						if (typeCheck >= 40 && typeCheck <= 49) {
							cType = 'Visa';
						}
						else if (typeCheck >= 51 && typeCheck <= 55) {
							cType = 'Master Card';
						}
						else if ((typeCheck >= 60 && typeCheck <= 62) || (typeCheck == 64) || (typeCheck == 65)) {
							cType = 'Discover';
						}
						else if (typeCheck==34 || typeCheck==37) {
							cType = 'American Express';
						}
						else {
							cType = 'Invalid';
						}
					}

					// all support card types have a 4 digit firt block
					block1 = ccNumString.substring(0, 4);
					if (block1.length == 4) {
						block1 = block1 + ' ';
					}

					if (cType == 'Visa' || cType == 'Master Card' || cType == 'Discover') {
						// for 4X4 cards
						block2 = ccNumString.substring(4, 8);
						if (block2.length == 4) {
							block2 = block2 + ' ';
						}
						block3 = ccNumString.substring(8, 12);
						if (block3.length == 4) {
							block3 = block3 + ' ';
						}
						block4 = ccNumString.substring(12, 16);
					}
					else if (cType == 'American Express') {
						// for Amex cards
						block2 =  ccNumString.substring(4, 10);
						if (block2.length == 6) {
							block2 = block2 + ' ';
						}
						block3 =  ccNumString.substring(10, 15);
						block4='';
					}
					else if (cType == 'Invalid') {
						// for Amex cards
						block1 =  typeCheck;
						block2 = '';
						block3 = '';
						block4 = '';
						alert('Número de tarjeta incorrecto');
					}

					formatted = block1 + block2 + block3 + block4;
					document.getElementById(ccid).value = formatted;
					document.getElementById(ctid).value = cType;
				}
			</script>

		@else
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
						installment: $('input[name="installment"]:checked').val(),
						course_id: {{ $course -> id }},
						amount: '{{ Auth::user() -> payments -> where('course_id', $course -> id) -> first() -> amount }}'
					});

					const paymentResponse = await fetch('/process_payment_installment', {
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
								Livewire.emit('paymenySq');
								//window.location.href = '{{ route('panel.courses') }}';
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
		    </script>
		@endif
	@endpush
</div>
