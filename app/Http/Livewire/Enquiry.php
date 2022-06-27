<?php

namespace App\Http\Livewire;

use App\Models\Enquiry as ModelsEnquiry;
use Livewire\Component;
use Livewire\WithPagination;

class Enquiry extends Component
{
    use WithPagination;

    public $userData;
    public
    $email = null ,
    $examId = null,
    $planId = null,
    $exams = null,
$plans = null;
   
    public function mount()
    {


    }

    public function view($id)
    {
       $this->userData = ModelsEnquiry::where('id',$id)->first();
       $this->emit('view-data');
    }



    public function render()
    {
        $datas = ModelsEnquiry::paginate(10);

        return view('livewire.enquiry',compact('datas'))->extends('layouts.master')->section('content');
    }
}
