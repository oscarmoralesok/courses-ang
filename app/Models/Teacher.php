<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = [];


    //RELATIONS
    public function course()
    {
        return $this -> belongsToMany(Course::Class);
    }
}
