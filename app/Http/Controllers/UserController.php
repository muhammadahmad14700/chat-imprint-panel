<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:user');
        //$this->middleware('auth','verified');
    }
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function index()
    {
        return view('layouts.user.index');
    }

    public function username()
    {
        return view('auth.addName');
    }

    public function save_name(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        
        $current_user = Auth::user();
        if (Auth::check())
        {
            $userid = Auth::user()->id;
            $name   = $request->input('name');
            $update = User::where('id', $userid)->update(['name' => $name,'verify_flag'=>'2']);
            return redirect()->route('password')->with(['message' => 'Name Added Successfully.']);
        }else{
            redirect()->route('/login');
        }
    }

    public function password()
    {
        return view('auth.addPassword');
    }
    public function save_password(Request $request)
    {
        $data = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if (Auth::check())
        {
            $userid     = Auth::user()->id;
            $password   = $request->input('password');
            $update     = User::where('id', $userid)->update(['password' => Hash::make($password),'verify_flag'=>'3']);
            return redirect()->route('user')->with(['message' => 'Registration Successful.']);
        }else{
            redirect()->route('/login');
        }
    }
}
