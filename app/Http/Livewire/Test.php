<?php

namespace App\Http\Livewire;

use App\Models\SubmittedTest;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Test extends Component
{
    use WithPagination;

    public $evaluators ,$evaluator_id = null,$test_id= null,$status= null;

    protected $listeners = [
      'evaluator' => 'evaluator',
      'test' => 'test',
      'status' => 'status',
    ];

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
        $this->evaluator_id = null;$this->test_id= null;$this->status= null;
    }

    public function test($id)
    {
        $this->test_id = $id;
        $data = SubmittedTest::where('id',$this->test_id)->first();
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
            }else{
                SubmittedTest::where('id',$this->test_id)->update([
                    'status' => $this->status,
                    'evaluator_id' => $this->evaluator_id
                ]);
                $this->resetData();
                $this->emit('updated');
            }
        }

        elseif ($this->status == 1) {
            SubmittedTest::where('id',$this->test_id)->update([
                'status' => $this->status,
            ]);
            $this->resetData();
            $this->emit('updated');
        }
    }

    public function mount()
    {
        $this->evaluators = User::where([['status',1],['user_type',2]])->get();
    }

    public function render()
    {

        $datas = SubmittedTest::select('id','test_id','user_id','evaluator_id','submited_file','created_at','status','updated_at')->with('user:id,name','evaluator:id,name','test:id,name,course_id','test.course:id,name,exam_id','test.course.exam:id,name')->orderBy('id','DESC')->paginate(10);

        return view('livewire.test',compact('datas'))->extends('layouts.master')->section('content');
    }
}
