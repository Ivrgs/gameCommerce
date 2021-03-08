<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
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
    public function updatePassword(Request $request, $id)
    {
        $user =  User::find($request->id);
        if(Hash::check($request->old_password, $user->password)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            auth()->logout();
            return redirect('/')->with('status-success','Your Password has been updated');
        //    return view('home')->with('Password has been updated');
        }else{

            return redirect('/home')->with('status-error','Your Old Password is not Matched');
            // return view('home')->with("Your Old Password is not Matched");
        }
    }

}
