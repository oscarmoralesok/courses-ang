<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];


    //RELATIONS
    public function course()
    {
        return $this -> belongsTo(Course::Class) -> withTrashed();
    }

    public function user()
    {
        return $this -> belongsTo(User::Class);
    }


    //SCOPES
    public function scopeSearch($query, $search)
    {
        if ( trim( $search ) )
            return $query -> whereHas('user', function (Builder $query) use ( $search ) {
                return $query -> where('name', 'like', "%$search%");
            }) -> orWhere('payer_email', 'like', "%$search%");
    }
}
