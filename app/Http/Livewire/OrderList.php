<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;
    public function render()
    {
        $datas = Order::where('status',1)->with('user','exams','courses')->orderBy('id','DESC')->paginate(10);
        
        return view('livewire.order-list',compact('datas'))->extends('layouts.master')->section('content');
    }
}
