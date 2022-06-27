<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\SubmittedTest;
use Carbon\Carbon;
use Livewire\Component;
use Auth;
class Dashboard extends Component
{

    public $testNotAssigned , $totalTest , $todayTest , $todayOrders , $totalOrders;
    public function mount()
    {
        if (Auth::user()->user_type ==1) {
            $this->testNotAssigned = SubmittedTest::where('status',0)->count();
        }
        if (Auth::user()->user_type ==1) {
            $this->totalTest = SubmittedTest::count();
        }else{
            $this->totalTest = SubmittedTest::where('evaluator_id',Auth::user()->id)->count();
        }
        if (Auth::user()->user_type ==1) {
            $this->todayTest = SubmittedTest::whereDate('created_at', Carbon::today())->count();
        }else{
            $this->todayTest = SubmittedTest::whereDate('created_at', Carbon::today())->where('evaluator_id',Auth::user()->id)->count();
        }


        $this->todayOrders = Order::where('status',1)->whereDate('created_at', Carbon::today())->count();
        $this->totalOrders = Order::where('status',1)->count();
    }

    public function render()
    {
        return view('livewire.dashboard')->extends('layouts.master')->section('content');
    }
}
