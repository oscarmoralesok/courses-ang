<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $guarded = [];


    //RELATIONS
    public function lesson()
    {
        return $this -> belongsTo(Lesson::Class);
    }
}
