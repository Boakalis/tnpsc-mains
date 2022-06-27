<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function settings()
    {
        $data = Setting::where('id',1)->first();
        return view('settings',compact('data'));
    }

    public function submitSettings(Request $request )
    {
        $validatedData = $request->validate(
            [
                'email' => 'required',
                'name' => 'required',
                'address' => 'required',
                'about' => 'required',
                'privacy' => 'required',
                'toc' => 'required',
            ]
        );
        $datas = $request->except('_token');
        Setting::updateOrCreate(['id'=>1],$datas);
        return redirect()->back()->with('success','Settings Updated Successfully');
    }

    public function contactSubmit(Request $request)
    {
        $validatedData = $request->validate(
            [
                'email' => 'required|email',
                'name' => 'required|max:255',
                'message' => 'required',
                'subject' => 'required',
            ]
        );

        Enquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'subject' => $request->subject,
        ]);

        return response()->json([
            'message' => 'ok'
        ]);
    }

}
