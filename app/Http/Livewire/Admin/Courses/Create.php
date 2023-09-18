<?php

namespace App\Http\Livewire\Admin\Courses;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $cover, $createArray;

    public function mount()
    {
        $this -> createArray = [
            'status' => 0,
            'suscription_enable' => 1,
            'posted_at' => date('d/m/Y'),
        ];
    }

    public function save()
    {
        $this -> validate([
            'createArray.name' => 'required',
            'cover' => 'required|image|mimes:png,jpg,jpeg|max:4096',
            'createArray.description' => 'required',
            'createArray.price_ars' => 'required',
            'createArray.price_usd' => 'required',
            'createArray.suscription_enable' => 'required',
            'createArray.status' => 'required',
            'createArray.posted_at' => 'required',
        ]);

        $datetime = explode('/', $this -> createArray['posted_at']);
        $posted_at = $datetime[2] . '-' . $datetime[1] . '-' . $datetime[0];

        $this -> createArray['posted_at'] = $posted_at;
        $this -> createArray['cover'] = $this -> cover -> store('img/courses');

        $course = Course::create( $this -> createArray );

        return redirect() -> route('admin.courses.show', $course);
    }

    public function render()
    {
        return view('livewire.admin.courses.create');
    }
}
