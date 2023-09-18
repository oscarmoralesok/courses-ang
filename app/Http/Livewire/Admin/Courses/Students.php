<?php

namespace App\Http\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Students extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search', 'paginate'];

    public $course, $search, $paginate = 20, $promo;

    public function mount( $course )
    {
        $this -> course = Course::where('slug', $course) -> firstOrfail();
    }

    public function render()
    {
        $course_id = $this -> course -> id;
        $students = User::search( $this -> search )
                       -> promo( $this -> promo )
                       -> where('role', User::STUDENT)
                       -> whereHas('courses', function (Builder $query) use ($course_id) {
                           $query -> where('course_id', $course_id);
                       })
                       -> with('student')
                       -> orderBy('id', 'DESC')
                       -> paginate( $this -> paginate );

        return view('livewire.admin.courses.students', compact('students'));
    }
}
