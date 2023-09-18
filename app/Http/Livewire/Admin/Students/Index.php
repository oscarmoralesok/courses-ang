<?php

namespace App\Http\Livewire\Admin\Students;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search, $paginate = 20, $promo;

    protected $queryString = ['search', 'paginate'];
    protected $paginationTheme = 'bootstrap';

    public function status(User $student, $status)
    {
        $student -> status = $status;
        $student -> save();

        $this -> emit('updated');
    }

    public function destroy(User $student)
    {
        $student -> delete();
        $this -> emit('deleted');
    }

    public function render()
    {
        $students = User::search( $this -> search )
                       -> promo( $this -> promo )
                       -> where('role', User::STUDENT)
                       -> with('student')
                       -> orderBy('id', 'DESC')
                       -> paginate( $this -> paginate );

        return view('livewire.admin.students.index', compact('students'));
    }
}
