<?php

namespace App\Http\Controllers;
use Auth; 
use App\Models\User  ;
use App\HttpRequests\SignupRequest;
use Illuminate\Http\Request;
    
class AuthController extends Controller
{
    public function getSignup(){
        return view('auth.signup') ;
    }

    public  function postSignup(SignupRequest $request){
        User::create([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect() 
            ->route('home')
            ->with('info', 'You are registered successfully.'); 

    }

    public function getSignin(){
        return view('auth.signin'); 
    }

    public function postSignin(Request $request){

        $this->validate($request, [
            'email' => 'required|email', 
            'password' => 'required|min:6' , 
        ]) ;
    
        if(!Auth::attempt( $request->only( ['email', 'password'] ), $request->has( 'remember' ) ))
        {
            return redirect()->back()->with('info', 'Wrong email or password');
        }

        return redirect()->route('user.profile', Auth::user()->username)->with('info', 'You are sign in successfuly'); 
    }

    public function getSignOut(){
        Auth::logout(); 
        return redirect()->route('auth.signin'); 
    }  
    
}
