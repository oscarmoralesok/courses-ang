<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index(Request $request)
    {
        $courses = Course::where('posted_at', '<=', date('Y-m-d 00:00:00')) -> where('suscription_enable', 1) -> whereStatus(1) -> orderBy('id', 'DESC') -> get();
        $futureCourses = Course::where('posted_at', '>=', date('Y-m-d 00:00:00')) -> where('suscription_enable', 1) -> whereStatus(1) -> orderBy('id', 'DESC') -> get();
        return view('web.index', compact('courses', 'futureCourses'));
    }

    public function course(Request $request, $course)
    {
        $course = Course::where('slug', $course) -> with('teachers') -> with('users') -> with('modules') -> first();

        $related_courses = Course::whereNot('id', $course -> id) -> take('5') -> inRandomOrder() -> get();

        return view('web.course', compact('course', 'related_courses'));
    }
}
