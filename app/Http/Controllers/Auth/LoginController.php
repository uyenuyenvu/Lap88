<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class LoginController extends Controller
{
    public function showLoginForm(){
        if(Auth::check()){
            return redirect()->route('frontend.index');
        }
        return view('frontend.auth.login');
    }

    public function showLoginFormAdmin(){
        // $cart = Cart::get($request->rowId);
        // Cart::update($request->rowId, $cart->qty + 1);
        if(Auth::check()){
            return redirect()->route('backend.dashboard');
        }
        
        return view('backend.auth.login');
    }

    public function login(LoginRequest $request){
        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if (Auth::attempt($data)){
            $request->session()->regenerate();
            if (Auth::user()->role == User::ROLE_MANAGE || Auth::user()->role == User::ROLE_STAFF){
                return redirect()->intended('admin');
            } else{
                return redirect()->intended('/');
            }
        } else{
            return back()->withErrors([
                'login' => 'Thông tin không chính xác'
            ]);
        }
    }
}
