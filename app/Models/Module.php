<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = [];

    protected $dates = [
        'posted_at'
    ];


    //RELATIONS
    public function lessons()
    {
        return $this -> hasMany(Lesson::Class);
    }

    public function course()
    {
        return $this -> belongsTo(Course::Class);
    }

    public function questions()
    {
        return $this -> hasMany(Question::Class);
    }


    //URL friendly
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
