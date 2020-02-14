<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }
    
    public function login(Request $request){

        $this->validateLogin($request);      
 
         if (Auth::attempt(['usuario' => $request->usuario,'password' => $request->password,'condicion'=>1])){
             return redirect()->route('main');
         }
 
         return back()->withErrors(['usuario' => trans('auth.failed')])
         ->withInput(request(['usuario']));
     }

     protected function validateLogin(Request $request){
        $this->validate($request,[
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }

}
