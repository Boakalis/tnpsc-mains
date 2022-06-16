<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Evaluator extends Component
{
    public $name,$description,$status=1,$datas ,$editId = null ,$email ,$phone ,$password;


    protected $listeners = [
        'select' => 'select',
    ];

    protected $rules = [
        'name' => 'required|max:255',
        'description' => 'required|max:255',

        'phone' => 'required|digits_between:7,10',
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
        $this->email=null;
        $this->phone=null;
        $this->status=1;
        $this->editId = null;
        $this->password = null;
    }


    public function edit($value)
    {
       $data = User::where('id',$value)->first();
       $this->name=$data->name;
       $this->description=$data->description;
       $this->email=$data->email;
       $this->phone=$data->phone;
       $this->status=$data->status;
       $this->emit('edit-data');
       $this->editId = $data->id;
    }

    public function save()
    {
        $this->validate();

        if ($this->editId != null) {

            $this->validate([
                'email' =>'email|unique:users,email,'.$this->editId.'id',
            ]);
            $data =[
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'description' => $this->description,
                'status' =>$this->status,
            ];

            if (isset($this->password) && !empty($this->password)) {
                $data['password'] = bcrypt($this->password);
            }
            User::where('id',$this->editId)->update($data);
        } else {
            $this->validate([
                'email' =>'email|unique:users',
                'password' => 'required|min:8|max:15',

            ]);
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'description' => $this->description,
                'status' =>$this->status,
                'password' => bcrypt($this->password),
                'user_type' => 2,
            ]);
        }


        $this->resetdata();
        $this->emit('added');
    }

    public function render()
    {
        $this->datas =User::where('user_type',2)->get();
        return view('livewire.evaluator')->extends('layouts.master')->section('content');
    }
}
