<?php

namespace App\Http\Livewire\Admin\Students;

use App\Models\Course;
use App\Models\ExamResult;
use App\Models\Payment;
use App\Models\ResponseStudent;
use App\Models\User;
use App\Notifications\SuscribeNotification;
use Livewire\Component;

class Show extends Component
{
    public $student, $courses, $addPaymentArray, $payment, $editPaymentArray, $add_course_id, $userArray, $studentArray;

    public function mount($student)
    {
        $this -> student = User::where('id', $student) -> with('student') -> with('payments') -> firstOrFail();
        $this -> courses = Course::orderBy('id', 'DESC') -> get();

        $this -> userArray['name'] = $this -> student -> name;
        $this -> userArray['email'] = $this -> student -> email;
        $this -> studentArray['birthdate'] = $this -> student -> student -> birthdate ? $this -> student -> student -> birthdate -> format('d/m/Y') : '';
        $this -> studentArray['address'] = $this -> student -> student -> address;
        $this -> studentArray['country'] = $this -> student -> student -> country;
        $this -> studentArray['phone'] = $this -> student -> student -> phone;
        $this -> studentArray['work'] = $this -> student -> student -> work;
        $this -> studentArray['church'] = $this -> student -> student -> church;
        $this -> studentArray['pastor'] = $this -> student -> student -> pastor;
        $this -> studentArray['ceap'] = $this -> student -> student -> ceap;
    }

    public function status(User $student, $value)
    {
        $student -> status = $status;
        $student -> save();

        $this -> student = $this -> student -> fresh();

        $this -> emit('updated');
    }

    public function statusPayment(Payment $payment, $value)
    {
        $payment -> status = $value;
        $payment -> save();

        $this -> student = $this -> student -> fresh();
        $this -> emit('updated');
    }

    public function addPayment()
    {
        $this -> validate([
            'addPaymentArray.payer_email' => 'required',
            'addPaymentArray.gateway' => 'required',
            'addPaymentArray.payment_id' => 'required',
            'addPaymentArray.amount' => 'required',
            'addPaymentArray.installment' => 'required',
            'addPaymentArray.course_id' => 'required',
        ]);

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $this -> addPaymentArray['token'] = substr(str_shuffle($permitted_chars), 0, 16);
        $this -> addPaymentArray['user_id'] = $this -> student -> id;

        Payment::create( $this -> addPaymentArray );

        $this -> student = $this -> student -> fresh();
        $this -> emit('saved');
    }

    public function editPayment(Payment $payment)
    {
        $this -> payment = $payment;
        $this -> editPaymentArray['payer_email'] = $payment -> payer_email;
        $this -> editPaymentArray['gateway'] = $payment -> gateway;
        $this -> editPaymentArray['payment_id'] = $payment -> payment_id;
        $this -> editPaymentArray['amount'] = $payment -> amount;
        $this -> editPaymentArray['installment'] = $payment -> installment;
        $this -> editPaymentArray['course_id'] = $payment -> course_id;
    }

    public function updatePayment()
    {
        $this -> payment -> update( $this -> editPaymentArray );
        $this -> student = $this -> student -> fresh();
        $this -> emit('updated');
    }

    public function destroyPayment(Payment $payment)
    {
        $payment -> delete();
        $this -> student = $this -> student -> fresh();
        $this -> emit('deleted');
    }

    public function resetExam($module_id)
    {
        ExamResult::where('module_id', $module_id) -> where('user_id', $this -> student -> id) -> delete();
        ResponseStudent::where('module_id', $module_id) -> where('user_id', $this -> student -> id) -> delete();
        $this -> student = $this -> student -> fresh();
        $this -> emit('deleted');
    }

    public function addCourse()
    {
        $course = Course::find($this -> add_course_id);
        $this -> student -> courses() -> attach( $this -> add_course_id );

        $this -> student -> notify( new SuscribeNotification($this -> student, $course) );
        $this -> student = $this -> student -> fresh();
        $this -> reset('add_course_id');
        $this -> emit('saved');
    }

    public function resendEmail(Course $course)
    {
        $this -> student -> notify( new SuscribeNotification($this -> student, $course) );
        $this -> emit('updated');
    }

    public function detachCourse($course)
    {
        $this -> student -> courses() -> detach( $course );
        $this -> student = $this -> student -> fresh();
        $this -> emit('updated');
    }

    public function update()
    {
        $this -> validate([
            'userArray.name' => 'required',
            'userArray.email' => 'required|email|unique:users,email,' . $this -> student -> id,
        ]);

        $datetime = explode('/', $this -> studentArray['birthdate']);
        $this -> studentArray['birthdate'] = $datetime[2] . '-' . $datetime[1] . '-' . $datetime[0];

        $this -> student -> update($this -> userArray);
        $this -> student -> student -> update($this -> studentArray);
        $this -> emit('updated');
    }


    public function render()
    {
        return view('livewire.admin.students.show');
    }
}
