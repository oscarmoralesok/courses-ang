<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;
use App\Notifications\SuscribeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Square\Apis\CatalogApi;
use Square\Environment;
use Square\Models\Builders\CreateCustomerRequestBuilder;
use Square\Models\Builders\CreateSubscriptionRequestBuilder;
use Square\SquareClient;
//use Stevebauman\Location\Facades\Location;

class PaymentController extends Controller
{

	public function paymentSquare(Request $request, Course $course)
	{
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($permitted_chars), 0, 12);

		$data = $request -> json() -> all();

		$client = new SquareClient([
			'accessToken' => config('services.square.token'),
			'environment' => Environment::PRODUCTION,
		]);

        /*$ip = ($request -> ip() == '127.0.0.1') ? '186.12.185.70' : $request -> ip();
        $geolocation = Location::get($ip);

		if ( $geolocation -> countryCode == 'VE' ) {
		} else {
		}*/

		$amount_money = new \Square\Models\Money();
		$amount_money -> setAmount( $course -> price_usd );
		$amount_money -> setCurrency('USD');

		$body = new \Square\Models\CreatePaymentRequest(
			$data['sourceId'],
			$code,
			$amount_money
		);

		$body -> setAutocomplete(true);
		$body -> setLocationId($data['locationId']);
		$body -> setNote( $course -> name );
		$body -> setReferenceId($code);

		$api_response = $client -> getPaymentsApi() -> createPayment( $body );

		if ( $api_response -> isSuccess() ) {

			Payment::create([
				'payer_email' => Auth::user() -> email,
				'gateway' => 'SQ',
				'payment_id' => $api_response -> getResult() -> getPayment() -> getId(),
				'token' => $code,
				'amount' => $course -> price_usd / 100,
				'status' => 1,
				'course_id' => $course -> id,
				'user_id' => Auth::user() -> id
			]);

			$answer = array(
				'state' => 'ok'
			);

			Auth::user() -> courses() -> attach( $course -> id );
			Auth::user() -> notify( new SuscribeNotification(Auth::user(), $course) );

		} else {

			$answer = array(
				'state' => 'error',
				'message' => $api_response -> getErrors()
			);
		}

		return json_encode($answer, JSON_FORCE_OBJECT);
	}

	public function paymentSquareMembership(Request $request)
	{
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$codeClient = substr(str_shuffle($permitted_chars), 0, 36);
		$codeSuscription = substr(str_shuffle($permitted_chars), 0, 36);

		$data = $request -> json() -> all();
		dd($data);

		$client = new SquareClient([
			'accessToken' => config('services.square.token'),
			'environment' => Environment::PRODUCTION,
		]);

		$customersApi = $client -> getCustomersApi();
		$subscriptionsApi = $client -> getSubscriptionsApi();

		// ID mio: SW42PWYC9KARVH5YZB0J4GGMKG
		/*
		//CREAR cliente
		$body = CreateCustomerRequestBuilder::init()
										   -> givenName('Oscar')
										   -> familyName('Morales')
										   -> emailAddress('morales.oscardavid@gmail.com')
										   -> referenceId($codeClient)
										   -> build();

		$responseCustomer = $customersApi -> createCustomer($body);

		if ($responseCustomer -> isSuccess()) {
		    $createCustomerResponse = $responseCustomer -> getResult();
		} else {
		    $errors = $responseCustomer -> getErrors();
		}*/


		//CREAR Plan
		$body = CreateSubscriptionRequestBuilder::init(
												  	$data['locationId'],
												  	'SW42PWYC9KARVH5YZB0J4GGMKG'
												  )
											   -> idempotencyKey($codeSuscription)
											   -> planVariationId('WEAQFCKZKH4G655LB2DMDRI5')
											   -> cardId($data['sourceId'])
											   -> build();

		$responseCustomer = $subscriptionsApi -> createSubscription($body);
		dd($responseCustomer);

		// ID del plan que deseas obtener
	    $planId = '2UCEF3LRXGD57PETRRMF2BZE'; //WEAQFCKZKH4G655LB2DMDRI5

	    // Crea una instancia de CatalogApi
	    $catalogApi = $client -> getCatalogApi();

	    // Realiza una solicitud para obtener el objeto del plan
	    $response = $catalogApi -> retrieveCatalogObject($planId);

	    // Verifica si la respuesta no está vacía y si no contiene errores
	    if (empty($response -> getErrors())) {
	    	$result = $response -> getResult() -> getObject() -> getSubscriptionPlanData();
	    	dd($result);
	        $plan = $response -> getResult();

	        // Obtiene el monto del plan desde los detalles del objeto
	        $planName = $plan->getName();
	        dd($planName);
	        $planAmount = $plan -> getItemVariationData() -> getPricing() -> getMoney() -> getAmount();

	        return response() -> json(['plan_amount' => $planAmount]);
	    } else {
	        return response() -> json(['error' => 'El ID del plan no corresponde a un plan válido en Square'], 404);
	    }



		/*$amount_money = new \Square\Models\Money();
		$amount_money -> setAmount( $course -> price_usd );
		$amount_money -> setCurrency('USD');

		$body = new \Square\Models\CreatePaymentRequest(
			$data['sourceId'],
			$code,
			$amount_money
		);

		$body -> setAutocomplete(true);
		$body -> setLocationId($data['locationId']);
		$body -> setNote( $course -> name );
		$body -> setReferenceId($code);

		$api_response = $client -> getPaymentsApi() -> createPayment( $body );

		if ( $api_response -> isSuccess() ) {

			Payment::create([
				'payer_email' => Auth::user() -> email,
				'gateway' => 'SQ',
				'payment_id' => $api_response -> getResult() -> getPayment() -> getId(),
				'token' => $code,
				'amount' => $course -> price_usd / 100,
				'status' => 1,
				'course_id' => $course -> id,
				'user_id' => Auth::user() -> id
			]);

			$answer = array(
				'state' => 'ok'
			);

			Auth::user() -> courses() -> attach( $course -> id );
			Auth::user() -> notify( new SuscribeNotification(Auth::user(), $course) );

		} else {

			$answer = array(
				'state' => 'error',
				'message' => $api_response -> getErrors()
			);
		}

		return json_encode($answer, JSON_FORCE_OBJECT);*/
	}

}
