<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request){
        try {
            if (Auth::user()->role == User::ROLE_MANAGE || Auth::user()->role == User::ROLE_STAFF){
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();
                return redirect()->route('login');
            }

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            return redirect()->route('frontend.index');
        } catch (\Exception $exception){
            return redirect()->route('frontend.index');
        }
    }
}
