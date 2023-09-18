<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function __invoke()
    {
        $courses = Course::all();
        $students = User::whereRole(2) -> get();
        $lastPayments = Payment::orderBy('id', 'DESC') -> take(5) -> get();

        return view('admin.dashboard', compact('courses', 'students', 'lastPayments'));
    }

}
