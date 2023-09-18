<?php

namespace App\Http\Livewire\Admin\Teachers;

use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
	use WithPagination;
	use WithFileUploads;

	public $photo, $createArray, $tchr, $photoEdit, $editArray;

	public function save()
	{
		$this -> validate([
			'photo' => 'required|image|mimes:png,jpg,jpeg|max:4096',
			'createArray.name' => 'required',
			'createArray.subtitle' => 'required',
			'createArray.description' => 'required',
		]);

		$this -> createArray['photo'] = $this -> photo -> store('/img/teachers');

		Teacher::create( $this -> createArray );

		$this -> reset(['createArray', 'photo']);
		$this -> emit('saved');
	}

	public function edit(Teacher $teacher)
	{
		$this -> tchr = $teacher;
		$this -> editArray['name'] = $teacher -> name;
		$this -> editArray['subtitle'] = $teacher -> subtitle;
		$this -> editArray['description'] = $teacher -> description;
		$this -> editArray['photo'] = $teacher -> photo;
	}

	public function update()
	{
		$this -> validate([
			'photoEdit' => 'nullable|image|mimes:png,jpg,jpeg|max:4096',
			'editArray.name' => 'required',
			'editArray.subtitle' => 'required',
			'editArray.description' => 'required',
		]);

		if ( $this -> photoEdit ) {
			Storage::disk('public') -> delete($this -> tchr -> photo);
			$this -> editArray['photo'] = $this -> photoEdit -> store('/img/teachers');
		}

		$this -> tchr -> update( $this -> editArray );

		$this -> reset(['editArray', 'photoEdit']);
		$this -> emit('updated');
	}

	public function destroy(Teacher $teacher)
	{
		$teacher -> delete();
		$this -> emit('deleted');
	}

	public function render()
	{
		$teachers = Teacher::orderBy('id', 'DESC') -> paginate();
		return view('livewire.admin.teachers.index', compact('teachers'));
	}
}
