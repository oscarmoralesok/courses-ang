<?php

namespace App\Http\Livewire\Admin\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $course, $cover, $editArray;

    public function mount(Course $course)
    {
        $this -> course = $course;
        $this -> editArray['status'] = $course -> status;
        $this -> editArray['cover'] = $course -> cover;
        $this -> editArray['description'] = $course -> description;
        $this -> editArray['posted_at'] = $course -> posted_at -> format('d/m/Y');
        $this -> editArray['suscription_enable'] = $course -> suscription_enable;
        $this -> editArray['name'] = $course -> name;
        $this -> editArray['excerpt'] = $course -> excerpt;
        $this -> editArray['price_ars'] = $course -> price_ars;
        $this -> editArray['price_usd'] = $course -> price_usd;
    }

    public function udpate()
    {
        $this -> validate([
            'editArray.name' => 'required',
            'cover' => 'nullable|image|mimes:png,jpg,jpeg|max:4096',
            'editArray.description' => 'required',
            'editArray.price_ars' => 'required',
            'editArray.price_usd' => 'required',
            'editArray.suscription_enable' => 'required',
            'editArray.status' => 'required',
            'editArray.posted_at' => 'required',
        ]);

        $datetime = explode('/', $this -> editArray['posted_at']);
        $this -> editArray['posted_at'] = $datetime[2] . '-' . $datetime[1] . '-' . $datetime[0];

        if ( $this -> cover ) {
            Storage::disk('public') -> delete($this -> course -> cover);
            $this -> editArray['cover'] = $this -> cover -> store('img/courses');
        }

        $this -> course -> update( $this -> editArray );
        return redirect() -> route('admin.courses.show', $this -> course) -> with('status', 'Información actualizada correctamente.');
    }

    public function render()
    {
        return view('livewire.admin.courses.edit');
    }
}
