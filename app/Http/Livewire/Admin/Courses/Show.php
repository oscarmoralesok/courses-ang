<?php

namespace App\Http\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\Module;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public $course, $addModuleArray, $editModuleArray, $module;

    public function mount($course)
    {
        $this -> course = Course::where('slug', $course) -> firstOrfail();
    }

    public function addModule()
    {
        $this -> validate([
            'addModuleArray.name' => 'required',
            'addModuleArray.number' => 'required',
            'addModuleArray.posted_at' => 'required',
        ]);

        $this -> addModuleArray['course_id'] = $this -> course -> id;

        $posted_at = explode('/', $this -> addModuleArray['posted_at']);
        $this -> addModuleArray['posted_at'] = $posted_at[2] . '-' . $posted_at[1] . '-' . $posted_at[0];

        Module::create( $this -> addModuleArray );

        $this -> reset('addModuleArray');
        $this -> course = $this -> course -> fresh();
        $this -> emit('updated');
    }

    public function editModule(Module $module)
    {
        $this -> module = $module;
        $this -> editModuleArray['name'] = $module -> name;
        $this -> editModuleArray['number'] = $module -> number;
        $this -> editModuleArray['posted_at'] = $module -> posted_at -> format('d/m/Y');
        $this -> emit('setPosted');
    }

    public function updateModule()
    {
        $this -> validate([
            'editModuleArray.name' => 'required',
            'editModuleArray.number' => 'required',
            'editModuleArray.posted_at' => 'required',
        ]);

        $posted_at = explode('/', $this -> editModuleArray['posted_at']);
        $this -> editModuleArray['posted_at'] = $posted_at[2] . '-' . $posted_at[1] . '-' . $posted_at[0];

        $this -> module -> update( $this -> editModuleArray );

        $this -> course = $this -> course -> fresh();
        $this -> emit('updated');
    }

    public function destroyModule(Module $module)
    {
        $module -> delete();
        $this -> course = $this -> course -> fresh();
        $this -> emit('deleted');
    }

    public function render()
    {
        return view('livewire.admin.courses.show');
    }
}
