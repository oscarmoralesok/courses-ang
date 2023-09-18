<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\SocialProfile;

class LoginController extends Controller
{
    
    public function redirect($driver)
    {
        $drivers = ['facebook', 'google'];

        if ( in_array($driver, $drivers) ) {
            return Socialite::driver( $driver ) -> redirect();
        } else {
            abort(404);
        }
    }

    public function callback(Request $request, $driver)
    {

        if ( $request -> error ) {
            return redirect() -> route('login');
        }

        $userCallback = Socialite::driver( $driver ) -> user();

        $socialProfile = SocialProfile::where('social_id', $userCallback -> id) -> where('social_name', $driver) -> first();

        if ( ! $socialProfile ) {

            $user = User::where('email', $userCallback -> email) -> first();

            //lo creo en caso de que no exista el user
            if ( ! $user ) {
                $user = User::create([
                    'name' => $userCallback -> name,
                    'email' => $userCallback -> email,
                    'last_login_at' => date('Y-m-d')
                ]);
            }

            $socialProfile = SocialProfile::create([
                'social_id' => $userCallback -> id,
                'social_name' => $driver,
                'social_avatar' => $userCallback -> avatar,
                'user_id' => $user -> id,
            ]);
        }

        Auth::login($socialProfile -> user);
        return redirect() -> route('redirects');
    }

}
