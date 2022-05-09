<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm(){
        return view('frontend.auth.register');
    }

    public function register(RegisterRequest $request){
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'role'  => 2,
        ]);

        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
    }
}
