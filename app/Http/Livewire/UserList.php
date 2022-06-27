<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

class UserList extends Component
{
    use WithPagination;

    public $userData;
    public
    $email = null ,
    $examId = null,
    $planId = null,
    $exams = null,
$plans = null;
    protected $listeners = [
        "examValue" => "examValue",
        "planValue" => "planValue",
    ];

    public function examValue($id)
    {
        $this->examId = $id;
        $this->plans = Course::where([['status',1],['exam_id',$id]])->get();
    }
    public function planValue($id)
    {
        $this->planId = $id;
    }

    public function mount()
    {
        $this->exams = Exam::where('status',1)->get();

    }

    public function view($id)
    {
       $this->userData = User::where('id',$id)->first();
       $this->emit('view-data');
    }

    public function addOrder()
    {
        if ($this->email == null || $this->examId== null || $this->planId == null) {
            $this->emit('validation');
            return;
        }
        if (User::where('email',$this->email)->doesntExist()) {
            $this->emit('no');
            return;
        }
        $user = User::where('email',$this->email)->first();
        if (Order::where([['user_id',$user->id],['status',1],['exam_id',$this->examId],['course_id',$this->planId]])->exists()) {
            $this->emit('already-purchased');
            return;
        }

        Order::create([
            'order_id' =>  Str::random(20),
            'user_id' => $user->id,
            'status' => 1,
            'amount' => Course::where('id',$this->planId)->pluck('price')->first(),
            'course_id' => $this->planId,
            'payment_type' => 2,
            'exam_id' => $this->examId,
        ]);

        $this->emit('created');


    }

    public function render()
    {
        $datas = User::paginate(10);

        return view('livewire.user-list',compact('datas'))->extends('layouts.master')->section('content');
    }
}
