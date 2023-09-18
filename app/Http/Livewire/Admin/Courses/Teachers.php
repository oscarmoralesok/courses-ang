<?php

namespace App\Http\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\Teacher;
use Livewire\Component;

class Teachers extends Component
{

    public $course, $course_teachers;

    public function mount( $course )
    {
        $this -> course = Course::where('slug', $course) -> firstOrfail();
    }

    public function addTeacher( $teacher )
    {
        $this -> course -> teachers() -> attach( $teacher );
        $this -> course = $this -> course -> fresh();
        $this -> emit('saved');
    }

    public function detachTeacher( $teacher )
    {
        $this -> course -> teachers() -> detach( $teacher );
        $this -> course = $this -> course -> fresh();
        $this -> emit('deleted');
    }

    public function render()
    {

        $teacher_course = $this -> course -> teachers;
        $ids = [];
        foreach ($teacher_course as $tc) {
            $ids[] = $tc -> id;
        }

        $teachers = Teacher::whereNotIn('id', $ids) -> orderBy('name') -> get();

        return view('livewire.admin.courses.teachers', compact('teachers'));
    }
}
