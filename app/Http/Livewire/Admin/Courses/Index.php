<?php

namespace App\Http\Livewire\Admin\Courses;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $paginate = 20;

    public function status(Course $course, $status)
    {
        $course -> status = $status;
        $course -> save();

        $this -> emit('updated');
    }

    public function destroy(Course $course)
    {
        $course -> delete();
        $this -> emit('deleted');
    }

    public function suscription(Course $course, $status)
    {
        $course -> suscription_enable = $status;
        $course -> save();

        $this -> emit('updated');
    }

    public function render()
    {
        $courses = Course::orderBy('id', 'DESC') -> paginate( $this -> paginate );
        return view('livewire.admin.courses.index', compact('courses'));
    }
}
