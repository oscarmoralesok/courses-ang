<?php

namespace App\Http\Livewire\Admin;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class Payments extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['paginate', 'search'];

    public $search, $paginate = 20;

    public function render()
    {
        $payments = Payment::search( $this -> search )
                          -> orderBy('id', 'DESC')
                          -> with('user')
                          -> with('course')
                          -> paginate( $this -> paginate );

        return view('livewire.admin.payments', compact('payments'));
    }
}
