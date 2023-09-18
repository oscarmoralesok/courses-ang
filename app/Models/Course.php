<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    protected $guarded = [];

    protected $dates = ['posted_at'];


    //RELATIONS
    public function users()
    {
        return $this -> belongsToMany(User::Class);
    }

    public function teachers()
    {
        return $this -> belongsToMany(Teacher::Class);
    }

    public function modules()
    {
        return $this -> hasMany(Module::Class);
    }

    public function lessons()
    {
        return $this -> hasMany(Lesson::Class);
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
