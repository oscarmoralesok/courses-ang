<?php

namespace App\Http\Livewire\Admin\Courses;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Module;
use App\Models\Question;
use Livewire\Component;

class ExamComponent extends Component
{

    public $course, $module, $addAnswerArray, $qstn, $editQuestionArray, $nswr, $editAnswerArray, $addQuestionArray;

    public function mount(Course $course, Module $module )
    {
        $this -> course = $course;
        $this -> module = $module;
    }

    public function statusExam($status)
    {
        $this -> module -> exam_status = $status;
        $this -> module -> save();
        $this -> emit('updated');
    }


    //QUESTIONS
    public function addQuestion()
    {
        $this -> validate([
            'addQuestionArray.question' => 'required',
            'addQuestionArray.number' => 'required'
        ]);

        $this -> addQuestionArray['module_id'] = $this -> module -> id;
        $this -> addQuestionArray['course_id'] = $this -> course -> id;

        Question::create( $this -> addQuestionArray );
        $this -> reset('addQuestionArray');
        $this -> emit('saved');
    }

    public function editQuestion(Question $question)
    {
        $this -> qstn = $question;
        $this -> editQuestionArray['question'] = $question -> question;
        $this -> editQuestionArray['number'] = $question -> number;
    }

    public function updateQuestion()
    {
        $this -> validate([
            'editQuestionArray.question' => 'required',
            'editQuestionArray.number' => 'required'
        ]);
        $this -> qstn -> update( $this -> editQuestionArray );
        $this -> reset('editQuestionArray');
        $this -> emit('updated');
    }

    public function destroyQuestion(Question $question)
    {
        $question -> delete();
        $this -> emit('deleted');
    }


    //ANSWERS
    public function addAnswer()
    {
        $this -> validate([
            'addAnswerArray.answer' => 'required',
            'addAnswerArray.correct' => 'required',
        ]);

        Answer::create( $this -> addAnswerArray );
        $this -> reset('addAnswerArray');
        $this -> emit('saved');
    }

    public function editAnswer(Answer $answer)
    {
        $this -> nswr = $answer;
        $this -> editAnswerArray['answer'] = $answer -> answer;
        $this -> editAnswerArray['correct'] = $answer -> correct;
    }

    public function updateAnswer()
    {
        $this -> nswr -> update( $this -> editAnswerArray );
        $this -> reset('editAnswerArray');
        $this -> emit('updated');
    }

    public function destroyAnswer(Answer $answer)
    {
        $answer -> delete();
        $this -> emit('deleted');
    }

    public function render()
    {
        $questions = Question::where('module_id', $this -> module -> id) -> get();
        return view('livewire.admin.courses.exam-component', compact('questions'));
    }
}
