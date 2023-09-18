<?php

namespace App\Http\Livewire\Web;

use App\Models\Membership;
use App\Models\MembershipPayment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class MembershipSuscription extends Component
{
    public $type, $amount = 0, $token, $error, $buyer = [], $email, $password, $userArray, $studentArray, $password_confirmation, $suscribed = false;

    public function mount(Request $request)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $this -> token = substr(str_shuffle($permitted_chars), 0, 16);

        if ( Auth::check() && Auth::user() -> membership ) {
            $this -> suscribed = true;
        }
    }

    public function login()
    {
        $this -> reset('error');

        $this -> validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ( Auth::attempt(array('email' => $this -> email, 'password' => $this -> password))){
            if ( Auth::user() -> membership ) {
                $this -> suscribed = true;
            }
            $this -> emit('renderSquare');
        } else {
            $this -> error = 'Los datos ingresados no coinciden con nuestra base de datos. Verifica que los hayas colocado correctamente y vuelve a intentarlo.';
        }
    }

    public function register()
    {
        $this -> validate([
            'userArray.name' => 'required',
            'userArray.email' => 'required|email|unique:users,email',
            'userArray.password' => 'required',
            'password_confirmation' => 'required|same:userArray.password',
            'studentArray.birthdate' => 'required',
            'studentArray.address' => 'required',
            'studentArray.country' => 'required',
            'studentArray.phone' => 'required',
            'studentArray.work' => 'required',
            'studentArray.church' => 'required',
        ]);

        $this -> userArray['password'] = Hash::make($this -> userArray['password']);
        $this -> userArray['last_login_at'] = date('Y-m-d H:i:s');

        $user = User::create( $this -> userArray );

        $datetime = explode('/', $this -> studentArray['birthdate']);
        $this -> studentArray['birthdate'] = $datetime[2] . '-' . $datetime[1] . '-' . $datetime[0];
        $this -> studentArray['user_id'] = $user -> id;

        Student::create($this -> studentArray);
        Auth::login($user);

        if ( Auth::user() -> membership ) {
            $this -> suscribed = true;
        }

        $this -> emit('renderSquare');
        $this -> emit('registered');
    }

    public function save()
    {
        $this -> reset('error');

        $this -> validate([
            'buyer.email' => 'required|email',
            'buyer.card_number' => ['required', new CardNumber],
            'buyer.expiration' => 'required|date_format:m/y',
            'buyer.cvv' => 'required|numeric|max_digits:4',
            'buyer.card_name' => 'required',
            'buyer.id' => 'required',
            'buyer.id_number' => 'required',
        ]);

        $cardnumber = str_replace(' ', '', $this -> buyer['card_number']);

        //$cardType = MercadoPago() -> paymentMethod() -> findCreditCard( $cardnumber );

        $datecard = explode('/', $this -> buyer['expiration']);

        $cardToken = MercadoPago() -> cardToken();

        $cardToken -> card_number = str_replace(' ', '', $this -> buyer['card_number']);
        $cardToken -> expiration_month = $datecard[0];
        $cardToken -> expiration_year = '20' . $datecard[1];
        $cardToken -> security_code = $this -> buyer['cvv'];
        $cardToken -> cardholder = [
            // este campo solo es obligatorio cuando hagas test, ya que de no ponerle un estado esperado mercado pago te arrojara un error cuando trates de generar un pago vía tarjeta
            'name' => $this -> buyer['card_name']
        ];

        $cardToken -> save();

        $expiration = date('Y-m-d', strtotime(date('Y-m-d') . '+1 months'));

        if ( $this -> type == 1 ) :
            $plan_name = 'Basic';
            $plan_id = '2c9380848245a71b01824b5ee29a02c7';
            $amount = 2925;
        else :
            $plan_name = 'Full';
            $plan_id = '2c938084823ab6e701824b60320406fa';
            $amount = 3450;
        endif;

        $external_reference = rand();

        $preapproval = MercadoPago() -> preapproval();
        $preapproval = MercadoPago() -> createPreapproval( $plan_name );
        $preapproval -> preapproval_plan_id = $plan_id;
        $preapproval -> external_reference = $external_reference;
        $preapproval -> payer_email = $this -> buyer['email'];
        $preapproval -> card_token_id = $cardToken -> id;
        $preapproval -> status = 'authorized';
        $preapproval -> save();

        Membership::create([
            'type' => $this -> type,
            'user_id' => Auth::user() -> id,
            'expiration' => $expiration
        ]);

        MembershipPayment::create([
            'payer_email' => $this -> buyer['email'],
            'gateway' => 'MP',
            'payment_id' => rand(),
            'token' => $this -> token,
            'amount' => $this -> type == 1 ? 100 : 500,
            'status' => 1,
            'membership_type' => $this -> type,
            'user_id' => Auth::user() -> id,
        ]);

        $this -> suscribed = true;
    }

    public function render()
    {
        return view('livewire.web.membership-suscription');
    }
}
