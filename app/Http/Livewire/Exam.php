<?php

namespace App\Http\Livewire;

use App\Models\Exam as ModelsExam;
use Livewire\Component;
use Str;
class Exam extends Component
{
    public $name,$description,$status=1,$datas ,$editId = null ,$slug;


    protected $listeners = [
        'select' => 'select',
    ];

    protected $rules = [
        'name' => 'required|max:255',
        'description' => 'required|max:255',
        'status' => 'required',
    ];

    public function updated($value)
    {
        $this->validateOnly($value);
    }

    public function select($id)
    {
        $this->status = $id ;
    }

    public function resetdata()
    {
        $this->name=null;
        $this->description=null;
        $this->status=1;
        $this->editId = null;
        $this->slug = null;
    }


    public function edit($value)
    {
       $data = ModelsExam::where('id',$value)->first();
       $this->name=$data->name;
       $this->description=$data->description;
       $this->status=$data->status;
       $this->slug = $data->slug;
       $this->emit('edit-data');
       $this->editId = $data->id;
    }

    public function save()
    {
        $this->validate();

        if ($this->editId != null) {
            $slug = Str::slug($this->name);
            ModelsExam::where('id',$this->editId)->update([
                'name' => $this->name,
                'description' => $this->description,
                'status' =>$this->status,
                'slug' => $slug
            ]);
        } else {
            ModelsExam::create([
                'name' => $this->name,
                'description' => $this->description,
                'status' =>$this->status,
            ]);
        }


        $this->resetdata();
        $this->emit('added');
    }

    public function render()
    {
        $this->datas =ModelsExam::get();
        return view('livewire.exam')->extends('layouts.master')->section('content');
    }
}
