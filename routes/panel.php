<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel;
use App\Http\Livewire\Panel as Livewire;

Route::get('dashboard', Panel\DashboardController::class) -> name('panel.dashboard');
Route::get('cursos', [Panel\CourseController::class, 'index']) -> name('panel.courses');

Route::get('cursos/{course}/{module?}/{lesson?}', Livewire\Courses\Show::class) -> name('panel.courses.show');

Route::view('/perfil', 'profile.show');

Route::get('/perfil', Livewire\Profile::class) -> name('panel.profile');