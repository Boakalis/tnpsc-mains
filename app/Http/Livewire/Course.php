<?php

namespace App\Http\Livewire;

use App\Models\Course as ModelsCourse;
use App\Models\Exam;
use App\Models\Test;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Str;

class Course extends Component
{
    use WithFileUploads;

    public
        $copyCourseId = 0,
        $testname,
        $testtype = 1,
        $teststatus = 1,
        $file,
        $testdata,
        $editTestId,
        $courseEditId,
        $limit = 1,
        $unlockTime = '';

    public
        $name,
        $description,
        $exams,
        $type = 1,
        $examId,
        $days,
        $status = 1,
        $price,
        $test,
        $videotype = 0,
        $testId,
        $link;


    protected $listeners = [
        'status' => 'status',
        'type' => 'type',
        'testview' => 'testview',
        'teststatus' => 'teststatus',
        'testtype' => 'testtype',
        'textAreaAdd' => 'textAreaAdd',
        'videotype' => 'videotype',
        'exam' => 'exam',
        'test' => 'test'
    ];

    public function textAreaAdd($value)
    {
        $this->description = $value;
        $this->save();
    }

    public function videotype($id)
    {
        $this->videotype = $id;
    }

    public function test($value)
    {

        $this->test = $value;

        $this->tests = Test::where([['course_id', $this->test], ['is_video', 0]])->get();

        $this->videos = Test::where([['course_id', $this->test], ['is_video', 1]])->get();
    }

    public function testview($value)
    {
        $this->tests = Test::where('course_id', $value)->get();
        $this->emit('test-view-edit');
    }

    public function mount()
    {
        $this->exams = Exam::where('status', 1)->get();

        $this->datas = ModelsCourse::get();
    }

    public function savetest()
    {
        $this->validate([
            'file' => 'required',
            'testname' => 'required',
        ], [
            'testname.required' => 'Test name is required',
            'file.required' => 'Please upload file',
        ]);
        $file_path = $this->file->store('files');

        Test::create([
            'name' => $this->name,
            'limit' => $this->limit,
            'file' => $file_path,
            'status' => $this->teststatus,
            'type' => $this->testtype,
            'course_id' => $this->test,
        ]);
        $this->resetdata();
        $this->emit('test-added');
    }

    protected $rules = [
        'name' => 'required|max:255',
        'description' => 'required',
        'type' => 'required|integer',
        'examId' => 'required|integer',
        'status' => 'required',
        'price' => 'required|integer',
    ];

    public function updated($value)
    {

        $this->validateOnly($value);
    }

    public function status($id)
    {
        $this->status = $id;
    }
    public function teststatus($id)
    {
        $this->teststatus = $id;
    }

    public function dehydrate()
    {
        $this->emit('initializeCkEditor');
    }


    public function resetdata()
    {
        $this->unlockTime = '';
        $this->description = null;
        $this->type = 1;
        $this->examId = null;
        $this->courseEditId = null;
        $this->price = null;
        $this->days = null;
        $this->status = 1;
        $this->copyCourseId = 0;
        $this->testname = null;
        $this->testtype = 1;
        $this->teststatus = 1;
        $this->file = null;
        $this->limit = 1;
        $this->videotype = 0;
        $this->link = null;
        $this->editTestId = null;
        $this->testId = null;
    }


    public function type($id)
    {
        $this->type = $id;
    }

    public function testtype($id)
    {
        $this->testtype = $id;
    }

    public function exam($id)
    {
        $this->examId = $id;
    }

    public function save()
    {
        $formated_description = str_replace('<li>', '-', str_replace('</li>', '', str_replace('</ul>', '', str_replace('<ul>', '', $this->description))));
        $final = json_encode(array_filter(explode('-', $formated_description)));
        $this->validate();
        if ($this->courseEditId != null) {
            if ($this->days != null) {
                $fileName =   $this->days->store('files', 'public');
                $datas['days'] = $fileName;
            }
            $datas = [
                'name' => $this->name,
                'benefits' => $this->description,
                'type' => $this->type,
                'exam_id' => $this->examId,
                'price' => $this->price,

                'formated' => $final,
                'status' => $this->status,
                'slug' => Str::slug($this->name),
            ];
            ModelsCourse::where('id', $this->courseEditId)->update($datas);
        } else {
            $validatedData = $this->validate([
                'days' => 'required',
            ]);
            if ($this->copyCourseId == 0) {
                if ($this->days != null) {
                    $fileName =   $this->days->store('files', 'public');
                }
                ModelsCourse::create([
                    'name' => $this->name,
                    'benefits' => $this->description,
                    'type' => $this->type,
                    'exam_id' => $this->examId,
                    'price' => $this->price,
                    'formated' => $final,
                    'days' => $fileName,
                    'status' => $this->status,
                    'slug' => Str::slug($this->name),
                ]);
            } else {
                if ($this->days != null) {
                    $fileName =   $this->days->store('files', 'public');
                }
                $course = ModelsCourse::create([
                    'name' => $this->name,
                    'benefits' => $this->description,
                    'type' => $this->type,
                    'exam_id' => $this->examId,
                    'price' => $this->price,
                    'days' => $fileName,
                    'formated' => $final,
                    'status' => $this->status,
                    'slug' => Str::slug($this->name),
                ]);

                foreach (Test::where('course_id', $this->copyCourseId)->select('name', 'limit', 'file', 'videolink', 'is_video', 'type', 'course_id', 'status')->get() as $key => $value) {
                    $value->course_id = $course->id;
                    Test::create($value->toArray());
                }
            }
        }
        $this->resetdata();
        $this->emit('added');
    }

    public function editCourse($value)
    {
        $data = ModelsCourse::where('id', $value)->first();

        $this->name = $data->name;
        $this->description = $data->benefits;
        $this->type = $data->type;
        $this->examId = $data->exam_id;
        // $this->days = $data->days;
        $this->unlockTime = $data->unlock_time;
        $this->price = $data->price;
        $this->status = $data->status;
        $this->copyCourseId = 0;
        $this->courseEditId = $data->id;
        $this->emit('edit-course');
    }

    public function testsave()
    {

        if ($this->editTestId == 1) {

            $this->validate([
                'testname' => 'required',
                'videotype' => 'required',
                'testtype' => 'required',
                'teststatus' => 'required',
            ], [
                'testname.required' => 'Test Name is required',
            ]);
            $datas = [
                'name' => $this->testname,
                'is_video' => $this->videotype,
                'type' => $this->testtype,
                'status' => $this->teststatus,
                'course_id' => $this->test,
            ];
            // if ($this->videotype == 1) {
            // $this->validate([
            //     'link' => 'required',
            // ]);
            $datas['videolink'] = $this->link;
            // } else if($this->videotype == 0) {
            // $this->validate([
            //     'limit' => 'required',
            //     'file' => 'nullable',
            // ]);
            $datas['limit'] = $this->limit;
            if ($this->file != null) {
                $datas['file'] =   $this->file->store('files', 'public');
            }
            // }
            $datas['unlock_time'] = $this->unlockTime;
            Test::where('id', $this->testId)->update($datas);
            $this->resetdata();
            $this->tests = Test::where([['course_id', $this->test], ['is_video', 0]])->get();
            $this->videos = Test::where([['course_id', $this->test], ['is_video', 1]])->get();
            $this->emit('test-updated');
        } else {

            $this->validate([
                'testname' => 'required',
                'videotype' => 'required',
                'testtype' => 'required',
                'teststatus' => 'required',
            ], [
                'testname.required' => 'Test Name is required',
            ]);
            $datas = [
                'name' => $this->testname,
                'is_video' => $this->videotype,
                'type' => $this->testtype,
                'status' => $this->teststatus,
                'course_id' => $this->test,
            ];
            // if ($this->videotype == 1) {
            //     $this->validate([
            //         'link' => 'required',
            //     ]);
            $datas['videolink'] = $this->link;
            // } else if($this->videotype == 0) {
            //     $this->validate([
            //         'limit' => 'required',
            //         'file' => 'required',
            //     ]);
            $datas['limit'] = $this->limit;
            $datas['unlock_time'] = $this->unlockTime;
            if ($this->file != null) {

                $datas['file'] =   $this->file->store('files', 'public');
            }
            // }
            Test::create($datas);
            $this->tests = Test::where([['course_id', $this->test], ['is_video', 0]])->get();
            $this->videos = Test::where([['course_id', $this->test], ['is_video', 1]])->get();
            $this->emit('test-added');
        }
        $this->resetdata();
    }


    public function deleteTest($value)
    {
        Test::where('id', $value)->delete();
        $this->tests = Test::where([['course_id', $this->test], ['is_video', 0]])->get();
        $this->videos = Test::where([['course_id', $this->test], ['is_video', 1]])->get();
    }

    public function downloadFile($value)
    {
        $path = Test::where('id', $value)->pluck('file')->first();
        return response()->download(public_path('storage/' . $path));
    }

    public function downloadSchedule($value)
    {
        $path = ModelsCourse::where('id', $value)->pluck('days')->first();
        return response()->download(public_path('storage/' . $path));
    }

    public function editTest($value)
    {

        $data = Test::where('id', $value)->first();
        $this->testname = $data->name;
        $this->videotype = $data->is_video;
        $this->testtype = $data->type;
        $this->teststatus = $data->status;
        $this->test = $data->course_id;
        $this->link = $data->videolink;
        $this->limit = $data->limit;
        $this->file = null;
        $this->testId = $data->id;
        $this->editTestId = 1;
    }



    public function render()
    {
        $contents = ModelsCourse::get();
        $this->testdata = ModelsCourse::where('id', $this->test)->first();
        return view('livewire.course', compact('contents'))->extends('layouts.master')->section('content');
    }
}
