<?php

namespace App\Http\Livewire\Web;

use App\Models\Course;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use App\Notifications\SuscribeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class Suscription extends Component
{
    public $course, $country, $token, $error, $buyer = [], $email, $password, $userArray, $studentArray, $password_confirmation, $availableCourses = 0;

    public function mount(Request $request)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $this -> token = substr(str_shuffle($permitted_chars), 0, 16);

        if ( Auth::check() && Auth::user() -> membership ) {
            if ( Auth::user() -> membership -> type == 1 ) {
                $qtyCourses = Auth::user() -> courses() -> wherePivot('created_at', 'like', date('Y-m') . '%') -> count();
                if ( $qtyCourses ) {
                    $this -> availableCourses = 0;
                } else {
                    $this -> availableCourses = 1;
                }
            } else {
                $this -> availableCourses = true;
            }
        }
    }

    public function save()
    {
        $this -> reset('error');

        $status = 0;

        if( $payment -> status == 'rejected' || $payment -> status == 'cancelled' || $payment -> status == 'refunded' || $payment -> status == 'charged_back' ) {
            $this -> emit('rejected');
        } elseif ( $payment -> status == 'approved' ){
            $status = 1;
        } elseif ( $payment -> status == 'pending' || $payment -> status == 'authorized' || $payment -> status == 'in_process' || $payment -> status == 'in_mediation' ) {
            $status = 2;
        } else {
            $this -> error = $payment -> error -> message;
        }

        if ( $status ) {
            Payment::create([
                'payer_email' => $this -> buyer['email'],
                'gateway' => 'MP',
                'payment_id' => $payment -> id,
                'token' => $this -> token,
                'amount' => $this -> course -> price_ars,
                'status' => $status,
                'course_id' => $this -> course -> id,
                'user_id' => Auth::user() -> id
            ]);

            Auth::user() -> courses() -> attach( $this -> course -> id );
            Auth::user() -> notify( new SuscribeNotification(Auth::user(), $this -> course) );

            $this -> reset('error');

            return redirect() -> route('panel.courses');
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
                if ( Auth::user() -> membership -> type == 1 ) {
                    $qtyCourses = Auth::user() -> courses() -> wherePivot('created_at', 'like', date('Y-m') . '%') -> count();
                    if ( $qtyCourses ) {
                        $this -> availableCourses = 0;
                    } else {
                        $this -> availableCourses = 1;
                    }
                } else {
                    $this -> availableCourses = true;
                }
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
            if ( Auth::user() -> membership -> type == 1 ) {
                $qtyCourses = Auth::user() -> courses() -> wherePivot('created_at', 'like', date('Y-m') . '%') -> count();
                if ( $qtyCourses ) {
                    $this -> availableCourses = 0;
                } else {
                    $this -> availableCourses = 1;
                }
            }
        }

        $this -> emit('registered');
        $this -> emit('renderSquare');
    }

    public function suscribe()
    {
        if ( $this -> availableCourses ) {
            Auth::user() -> courses() -> attach( $this -> course -> id );
            Auth::user() -> notify( new SuscribeNotification(Auth::user(), $this -> course) );
            return redirect() -> route('panel.courses');
        } else {
            $this -> error = 'No se puede realizar la inscripción al curso. Segun nuestros registros ya haz utilizado tu cupo mensual.';
        }
    }
}
