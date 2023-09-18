<?php

namespace App\Http\Livewire\Admin\Courses\Lessons;

use App\Models\Archive;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Video;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
	use WithFileUploads;

	public $lesson, $course, $editArray, $videoArray = [], $filesArray = [], $q_videos = 1, $q_files = 1;

	public function mount(Course $course, Module $module, Lesson $lesson)
	{
		$this -> module = $module;
		$this -> course = $course;
		$this -> lesson = $lesson;

		$this -> editArray['title'] = $lesson -> title;
		$this -> editArray['number'] = $lesson -> number;
		$this -> editArray['duration'] = $lesson -> duration;
		$this -> editArray['description'] = $lesson -> description;
	}

	public function addVideo()
	{
		$this -> q_videos = $this -> q_videos + 1;
	}

	public function addFile()
	{
		$this -> q_files = $this -> q_files + 1;
	}

	public function update()
	{
		$this -> validate([
			'editArray.title' => 'required',
			'editArray.description' => 'required',
			'editArray.duration' => 'required',
			'editArray.number' => 'required',
		]);

		$this -> lesson -> update( $this -> editArray );

		foreach ($this -> videoArray as $va) {
			if ( $va['url'] ) {
				Video::firstOrCreate([
					'url' => $va['url'],
					'number' => $va['number'],
					'lesson_id' => $this -> lesson -> id,
				]);
			}
		}

		foreach ($this -> filesArray as $file) {
			if ( $file['file'] ) {
				$path = $file['file'] -> store('files');
				Archive::firstOrCreate([
					'name' => $file['name'],
					'number' => $file['number'],
					'path' => $path,
					'lesson_id' => $this -> lesson -> id,
				]);
			}
		}

		$this -> lesson = $this -> lesson -> fresh();
		$this -> emit('updated');
	}

	public function destroyVideo(Video $video)
	{
		$video -> delete();
		$this -> emit('deleted');
	}
	
	public function destroyArchive(Archive $archive)
	{
		$archive -> delete();
		$this -> emit('deleted');
	}

	public function render()
	{
		return view('livewire.admin.courses.lessons.edit');
	}
}
