<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    //user ROLES
    const ADMIN = 1;
    const STUDENT = 2;

    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'role',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $data = [
        'last_login_at',
    ];


    //RELATIONS
    public function socialProfiles()
    {
        return $this -> hasMany(SocialProfile::Class);
    }

    public function student()
    {
        return $this -> hasOne(Student::Class);
    }

    public function courses()
    {
        return $this -> belongsToMany(Course::Class) -> withTimestamps();
    }

    public function completeLessons()
    {
        return $this -> hasMany(CompleteLesson::Class);
    }

    public function examResults()
    {
        return $this -> hasMany(ExamResult::Class);
    }

    public function payments()
    {
        return $this -> hasMany(Payment::Class);
    }

    public function responses()
    {
        return $this -> hasMany(ResponseStudent::Class);
    }

    public function membership()
    {
        return $this -> hasOne(Membership::Class);
    }

    public function membershipPayments()
    {
        return $this -> hasMany(MembershipPayment::Class);
    }


    //SCOPES
    public function scopeSearch($query, $search)
    {
        if ( trim( $search ) )
            return $this -> where(\DB::raw("CONCAT(name, ' ', email)"), 'like', "%$search%");
    }

    public function scopePromo($query, $promo)
    {
        if ( trim( $promo ) )
            return $this -> whereHas('student', function (Builder $query) use ($promo) {
                return $query -> where('promo', $promo);
            });
    }

}
