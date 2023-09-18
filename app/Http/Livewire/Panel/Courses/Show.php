<?php

namespace App\Http\Livewire\Panel\Courses;

use App\Models\CompleteLesson;
use App\Models\Course;
use App\Models\ExamResult;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Payment;
use App\Models\Question;
use App\Models\ResponseStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelMercadoPago\MercadoPago;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class Show extends Component
{
    public $course ,$country, $module_exam, $leccion, $exam, $buyer, $question, $questions, $showExam, $showResult;

    protected $queryString = ['leccion'];

    protected $listeners = ['paymenySq'];

    public function mount(Request $request, Course $course)
    {
        $ip = ($request -> ip() == '127.0.0.1') ? '186.12.185.70' : $request -> ip();
        $geolocationInformation = Location::get($ip);
        //dd($geolocationInformation);
        $this -> country = $geolocationInformation -> countryName;//"Argentina";
        $this -> course = $course;
    }

    public function lessonEnd()
    {
        $lesson = Lesson::whereSlug($this -> leccion) -> first();
        CompleteLesson::create([
            'lesson_id' => $lesson -> id,
            'course_id' => $this -> course -> id,
            'user_id' => Auth::user() -> id,
        ]);

        $this -> emit('saved');
    }

    public function paymenySq()
    {
        $this -> emit('saved');
    }

    public function loadPayment($installment, $amount)
    {
        $this -> buyer['installment'] = $installment;
        $this -> buyer['amount'] = $amount;
    }

    public function savePaymentMP()
    {
        $this -> validate([
            'buyer.email' => 'required|email',
            'buyer.card_number' => 'required',
            'buyer.expiration' => 'required',
            'buyer.cvv' => 'required',
            'buyer.card_name' => 'required',
            'buyer.id' => 'required',
            'buyer.id_number' => 'required',
        ]);

        $cardType = MercadoPago() -> paymentMethod() -> findCreditCard( str_replace(' ', '', $this -> buyer['card_number']) );

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


        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = substr(str_shuffle($permitted_chars), 0, 16);


        $payment = MercadoPago() -> payment();
 
        $payment -> transaction_amount = (float)$this -> buyer['amount'];
        $payment -> token = $cardToken -> id;
        $payment -> description = $this -> course -> name;
        $payment -> installments = 1;
        $payment -> payment_method_id = $cardType -> id;
        $payment -> external_reference = $token;
        $payment -> issuer_id = $cardType -> issuer -> id;

        $payment -> payer = array(
            'email' => $this -> buyer['email'],
            'identification' => array(
                'type' => $this -> buyer['id'],
                'number' => $this -> buyer['id_number']
            )
        );

        $payment -> save();

        $status = 0;

        if( $payment -> status == 'rejected' || $payment -> status == 'cancelled' || $payment -> status == 'refunded' || $payment -> status == 'charged_back' ) {
            $this -> emit('rejected');
        } elseif ( $payment -> status == 'approved' ){
            $status = 1;
        } elseif ( $payment -> status == 'pending' || $payment -> status == 'authorized' || $payment -> status == 'in_process' || $payment -> status == 'in_mediation' ) {
            $status = 2;
        }

        if ( $status ) {
            Payment::create([
                'payer_email' => $this -> buyer['email'],
                'gateway' => 'MP',
                'payment_id' => $payment -> id,
                'token' => $token,
                'amount' => $this -> buyer['amount'],
                'installment' => $this -> buyer['installment'],
                'status' => $status,
                'course_id' => $this -> course -> id,
                'user_id' => Auth::user() -> id
            ]);

            $this -> reset('buyer');
            $this -> emit('saved');
        }
    }

    public function loadExam(Module $module)
    {
        $this -> reset('leccion');
        $this -> exam = 1;

        if ( Auth::user() -> examResults -> where('module_id', $module -> id) -> first() ) {
            $this -> showResult = 1;
            $this -> showExam = 0;
        } else {
            $this -> showExam = 1;
            $this -> showResult = 0;

            ExamResult::create([
                'score' => 0,
                'module_id' => $module -> id,
                'course_id' => $this -> course -> id,
                'user_id' => Auth::user() -> id
            ]);
        }

        $this -> module_exam = $module;
        $this -> questions = $module -> questions;
    }

    public function sendAnswers()
    {
        foreach ($this -> question as $key => $value) {
            $question = Question::find($key);

            ResponseStudent::create([
                'module_id' => $question -> module_id,
                'question_id' => $key,
                'answer_id' => $value,
                'user_id' => Auth::user() -> id,
            ]);
        }

        $module = Module::find($question -> module_id);

        $correct_user = 0;
        foreach ( $module -> questions as $question) {
            if ( in_array($question -> answers -> where('correct', 1) -> first() -> id , $this -> question) ) {
                $correct_user++;
            }
        }

        $percent = $correct_user * 100 / $module -> questions -> count();

        $result = ExamResult::where('user_id', Auth::user() -> id) -> where('module_id', $module -> id) -> first();
        $result -> score = $percent;
        $result -> save();

        $this -> emit('saved');
        $this -> loadExam($module);
    }

    public function render()
    {
        if ( ! Auth::user() -> courses() -> wherePivot('course_id', $this -> course -> id) -> first() ) {
            return abort(404);
        }

        $lesson = Lesson::whereSlug($this -> leccion) -> first();
        $module = null;
        if ( $lesson ) {
            $module = Module::whereSlug($lesson -> module -> slug) -> first();
        }

        $completeLesson = false;
        if ( isset($lesson) && $lesson -> complete -> where('user_id', Auth::user() -> id) -> first() ) {
            $completeLesson = true;
        }

        return view('livewire.panel.courses.show', compact('lesson', 'module', 'completeLesson')) -> layout('layouts.panel');
    }
}
