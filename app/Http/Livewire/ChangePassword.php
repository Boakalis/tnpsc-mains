<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Auth;

class ChangePassword extends Component
{

    public $password ,$confirmPassword;

    public function update()
    {
        if ($this->password == null || $this->confirmPassword == null) {
            $this->emit('required');
            return ;
        }

        if (strlen($this->password) < 6 || strlen($this->confirmPassword) < 6 ) {
            $this->emit('invalid');
            return ;
        }
        if ($this->password != $this->confirmPassword ) {
            $this->emit('mismatch');
            return ;
        }

        User::where('id',Auth::user()->id)->update([
            'password' => bcrypt($this->password)
        ]);
        $this->password = null;
        $this->confirmPassword = null;
        $this->emit('updated');

    }

    public function render()
    {
        return view('livewire.change-password')->extends('layouts.master')->section('content');
    }
}
