<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Livewire\Admin as Livewire;


Route::get('/dashboard', Admin\DashboardController::class) -> name('admin.dashboard');

//Students
Route::get('/alumnos', Livewire\Students\Index::class) -> name('admin.students.index');
Route::get('/alumnos/{student}', Livewire\Students\Show::class) -> name('admin.students.show');

//Courses
Route::get('/curso', Livewire\Courses\Index::class) -> name('admin.courses.index');
Route::get('/curso/crear', Livewire\Courses\Create::class) -> name('admin.courses.create');
Route::get('/curso/{course}/modulos', Livewire\Courses\Show::class) -> name('admin.courses.show');
Route::get('/curso/{course}/profesores', Livewire\Courses\Teachers::class) -> name('admin.courses.teachers');
Route::get('/curso/{course}/editar', Livewire\Courses\Edit::class) -> name('admin.courses.edit');
Route::get('/curso/{course}/alumnos', Livewire\Courses\Students::class) -> name('admin.courses.students');
Route::get('/curso/{course}/{module}/examen', Livewire\Courses\ExamComponent::class) -> name('admin.courses.exam');
Route::get('/curso/{course}/{module}/lecciones/agegar', Livewire\Courses\Lessons\Create::class) -> name('admin.courses.lessons.create');
Route::get('/curso/{course}/{module}/lecciones/{lesson}', Livewire\Courses\Lessons\Edit::class) -> name('admin.courses.lessons.edit');

Route::post('image/upload', [Admin\ImageController::class, 'upload']) -> name('image.upload');

Route::get('/profesores', Livewire\Teachers\Index::class) -> name('admin.teachers.index');

Route::get('/pagos', Livewire\Payments::class) -> name('admin.payments.index');

Route::get('/usuarios', Livewire\Users\Index::class) -> name('admin.users.index');

Route::get('/perfil', Livewire\Profile::class) -> name('admin.profile');