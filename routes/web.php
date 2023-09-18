<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\Web;
use App\Http\Livewire\Web as Livewire;


Route::get('redirects', function ()
{
    if ( Auth::user() -> role == 1 ):
        return redirect() -> route('admin.dashboard');
    else :
        if ( url()->previous() == url('/login') ) {
            return redirect() -> route('panel.dashboard');
        } elseif ( url()->previous() == url('/register') ) {
            return redirect() -> route('web.index');
        } else {
            return back();
        }
    endif;

}) -> name('redirects');


Route::get('/login/{driver}', [Controllers\LoginController::class, 'redirect']);
Route::get('/login/{driver}/callback', [Controllers\LoginController::class, 'callback']);

Route::get('/', [Web\IndexController::class, 'index']) -> name('web.index');
Route::get('/curso/{course}', [Web\IndexController::class, 'course']) -> name('web.course');


//PAYMENT
Route::get('mp', [Web\PaymentController::class, 'test']);
Route::post('/process_payment/{course}', [Web\PaymentController::class, 'paymentSquare']) -> name('process_payment');
Route::get('/process_payment_membership', [Web\PaymentController::class, 'paymentSquareMembership']) -> name('process_payment_membership');