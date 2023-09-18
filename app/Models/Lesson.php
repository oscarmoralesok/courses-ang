<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = [];


    //RELATIONS
    public function module()
    {
        return $this -> belongsTo(Module::Class);
    }

    public function course()
    {
        return $this -> belongsTo(Course::Class);
    }

    public function videos()
    {
        return $this -> hasMany(Video::Class);
    }

    public function archives()
    {
        return $this -> hasMany(Archive::Class);
    }

    public function complete()
    {
        return $this -> hasMany(CompleteLesson::Class);
    }


    //URL friendly
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
