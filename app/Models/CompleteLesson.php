<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteLesson extends Model
{
    use HasFactory;

    protected $guarded = [];


    //RELATIONS
    public function lesson()
    {
        return $this -> belongsTo(Lesson::Class);
    }

    public function course()
    {
        return $this -> belongsTo(Course::Class);
    }

    public function user()
    {
        return $this -> belongsTo(User::Class);
    }
}
