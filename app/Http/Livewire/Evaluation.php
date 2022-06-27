<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use App\Models\SubmittedTest;
use Livewire\Component;
use Auth;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Evaluation extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $evaluators, $evaluator_id = null, $test_id = null, $status = null, $unique = null, $eFile;

    protected $listeners = [
        'evaluator' => 'evaluator',
        'test' => 'test',
        'status' => 'status',
    ];


    public function validateCode()
    {
        if ($this->unique == null) {
            $this->emit('null');
            return;
        }
        $explodedCode = explode('-', $this->unique);
        $fileName = $explodedCode[0];
        if (SubmittedTest::where('unique_id', $fileName)->exists()) {
            if ($fileName == $this->unique) {
                if (SubmittedTest::where('unique_id', $fileName)->pluck('evaluated_file')->first() == null) {
                    $this->emit('ok');
                } else {
                    $this->emit('already-updated');
                }
            } else {
                $this->emit('invalid');
            }
        } else {
            $this->emit('invalid');
        }
    }

    public function uploadFile()
    {
        if ($this->eFile != null) {
            $explodedCode = explode('-', $this->unique);
            $fileName = $explodedCode[0];
            $file = ($this->eFile->getClientOriginalName());
            $explodedCode = explode('.', $file);

            if ($explodedCode[0] == $this->unique.'-'.'evaluated') {
                    if (SubmittedTest::where('unique_id',$this->unique)->pluck('evaluated_file')->first() != null) {
                        $this->emit('already-updated');
                    }else{
                        $fileName =   $this->eFile->store('files', 'public');
                        SubmittedTest::where('unique_id',$this->unique)->update([
                            'status' => 1,
                            'evaluated_file' => $fileName,
                        ]);
                        $data = SubmittedTest::where('unique_id',$this->unique)->select('id','test_id','user_id')->with('test:id,name,course_id','test.course:id,name,exam_id','test.course.exam:id,name')->orderBy('id','DESC')->first();
                        Notification::create([
                            'user_id' => SubmittedTest::where('unique_id',$this->unique)->pluck('user_id')->first(),
                            'title' => $data->test->name.' in '.$data->test->course->exam->name.' was evaluated and ready for download',
                        ]);
                        $this->emit('success');
                        $this->unique =null;
                    }
            } else {
                $this->emit('invalid-file');

            }
        }else{
            $this->emit('no-file');
        }
    }

    public function evaluator($id)
    {
        $this->evaluator_id = $id;
    }
    public function status($id)
    {
        $this->status = $id;
    }

    public function resetData()
    {
        $this->evaluator_id = null;
        $this->test_id = null;
        $this->status = null;
    }

    public function test($id)
    {
        $this->test_id = $id;
        $data = SubmittedTest::where('id', $this->test_id)->first();
        $this->evaluator_id = $data->evaluator_id;
        $this->status = $data->status;
        $this->emit('update-status');
    }

    public function save()
    {
        if ($this->status == null) {
            $this->emit('status-error');
            return;
        }

        if ($this->status == 2) {
            if ($this->evaluator_id == null) {
                $this->emit('evaluator-error');
            } else {
                SubmittedTest::where('id', $this->test_id)->update([
                    'status' => $this->status,
                    'evaluator_id' => $this->evaluator_id
                ]);
                $this->resetData();
                $this->emit('updated');
            }
        } elseif ($this->status == 1) {
            SubmittedTest::where('id', $this->test_id)->update([
                'status' => $this->status,
            ]);
            $this->resetData();
            $this->emit('updated');
        }
    }

    public function downloadFile($value)
    {
        $path = SubmittedTest::where('id', $value)->first();
        $input = $path->submited_file;
        $result = explode('.', $input);


        return response()->download(public_path($path->submited_file), $path->unique_id . '.' . $result[1]);
    }

    public function mount()
    {
    }

    public function render()
    {
        if (Auth::user()->user_type == 1) {
            $datas = SubmittedTest::select('id', 'test_id', 'user_id', 'evaluator_id', 'submited_file', 'created_at', 'status', 'updated_at')->with('user:id,name', 'evaluator:id,name', 'test:id,name,course_id', 'test.course:id,name,exam_id', 'test.course.exam:id,name')->orderBy('id', 'DESC')->paginate(10);
        } else {
            $datas = SubmittedTest::where('evaluator_id', Auth::user()->id)->select('id', 'test_id', 'user_id', 'evaluator_id', 'submited_file', 'created_at', 'status', 'updated_at')->with('user:id,name', 'evaluator:id,name', 'test:id,name,course_id', 'test.course:id,name,exam_id', 'test.course.exam:id,name')->orderBy('id', 'DESC')->paginate(10);
        }


        return view('livewire.evaluation',compact('datas'))->extends('layouts.master')->section('content');
    }
}
