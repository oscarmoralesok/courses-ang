<?php

namespace App\Http\Livewire\Admin\Courses\Lessons;

use App\Models\Archive;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Video;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $course, $module, $createArray, $videoArray, $filesArray = [], $q_videos = 1, $q_files = 1;

    public function mount(Course $course, Module $module)
    {
        $this -> module = $module;
        $this -> course = $course;
        $this -> createArray['module_id'] = $module -> id;
        $this -> createArray['course_id'] = $course -> id;
    }

    public function addVideo()
    {
        $this -> q_videos = $this -> q_videos + 1;
    }

    public function addFile()
    {
        $this -> q_files = $this -> q_files + 1;
    }

    public function save()
    {
        $this -> validate([
            'createArray.title' => 'required',
            'createArray.description' => 'required',
            'createArray.duration' => 'required',
            'createArray.number' => 'required',
            'videoArray' => 'required|array|min:1',
        ]);

        $lesson = Lesson::create( $this -> createArray );

        foreach ($this -> videoArray as $va) {
            Video::create([
                'url' => $va['url'],
                'number' => $va['number'],
                'lesson_id' => $lesson -> id,
            ]);
        }

        if ( count( $this -> filesArray ) ) {
            foreach ($this -> filesArray as $fa) {
                if ( $fa['name'] ) {

                    $archive = $fa['file'] -> store('files');

                    Archive::create([
                        'name' => $fa['name'],
                        'path' => $archive,
                        'number' => $fa['number'],
                        'lesson_id' => $lesson -> id,
                    ]);
                }
            }
        }

        return redirect() -> route('admin.courses.lessons.edit', [$this -> course, $this -> module, $lesson]) -> with('status', 'Lección agregada correctamente.');
    }

    public function render()
    {
        return view('livewire.admin.courses.lessons.create');
    }
}
