<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function __invoke()
    {
        $courses = Course::whereStatus(1) -> orderBy('id', 'DESC') -> get();
        return view('panel.dashboard', compact('courses'));
    }

}
