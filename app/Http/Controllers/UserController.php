<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
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
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');

    }
    public function about(){
        return view('about');
    }
    public function sendEmail(){
        // $to_name ='Ivrgs';
        // $to_email ='ivargasrodel@gmail.com';
        // $data = array('name'=>"gameCommerce", "body" => "Welcome to gameCommerce");

        // Mail::send('email',
        //     $data, function($message) use ($to_name, $to_email) {
        //         $message->to($to_email, $to_name)->subject('Laravel Test Mail');
        //         $message->from(env("MAIL_USERNAME"),'gameCommerce Admin');
        //     });

        // $mj = new \Mailjet\Client('561f80e0460466295fe63b7d96be352d', 'c63a61fa9a1da8524df9ce993c40c13f', true, ['version' => 'v3.1']);
        // $body = [
        //     'Messages' => [
        //         [
        //             'From' => [
        //                 'Email' => "kazneechan@gmail.com",
        //                 'Name' => "Eleanor"
        //             ],
        //             'To' => [
        //                 [
        //                     'Email' => "kazneechan@gmail.com",
        //                     'Name' => "Eleanor"
        //                 ]
        //             ],
        //             'Subject' => "Greetings from Mailjet.",
        //             'TextPart' => "My first Mailjet email",
        //             'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
        //             'CustomID' => "AppGettingStartedTest"
        //         ]
        //     ]
        // ];
        // $response = $mj->post(Resources::$Email, ['body' => $body]);
        // $response->success() && var_dump($response->getData());

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
