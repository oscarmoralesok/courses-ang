<?php

namespace App\Actions\Fortify;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'birthdate' => 'required',
            'address' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'work' => 'required',
            'church' => 'required',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'last_login_at' => date('Y-m-d')
        ]);

        $datetime = explode('/', $input['birthdate']);
        $birthdate = $datetime[2] . '-' . $datetime[1] . '-' . $datetime[0];

        if ( date('m') == 12 )
            $promo = date('Y') + 1;
        else
            $promo = date('Y');

        Student::create([
            'address' => $input['address'],
            'country' => $input['country'],
            'phone' => $input['phone'],
            'work' => $input['work'],
            'church' => $input['church'],
            'birthdate' => $birthdate,
            'user_id' => $user -> id,
        ]);

        return $user;
    }
}
