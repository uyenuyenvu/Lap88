<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\SendMailResetPassword;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function sendMail(Request $request)
    {
        $email = $request->get('email');
        $user = User::where('email', $email)->first('name');
        $tokenRandom = Str::random(20);

        $passwordReset = new PasswordReset;
        $passwordReset->email = $email;
        $passwordReset->token = $tokenRandom;
        $passwordReset->save();

        $token = [
            'token' => $tokenRandom,
            'name'  => $user->name
        ];
        \Mail::to($email)->send(new SendMailResetPassword($token));

        if ($passwordReset){
            alert()->success('Đã xác nhận yêu cầu', 'Vui lòng kiểm tra email');
        } else {
            alert()->error('Yêu cầu chưa được thực hiện', 'Vui lòng thử lại');
        }
        return redirect()->route('frontend.index');
    }

    public function formResetPassword(Request $request){
        $token = $request->get('_token');
        if ($check = PasswordReset::where('token', $token)->first()){
            return view('frontend.pages.reset_password')->with([
                'token' => $token
            ]);
        }
        abort(404);
    }

    public function resetPassword(ResetPasswordRequest $request){
        $token = $request->except('_token');
        $email = PasswordReset::where('token', $token['token'])->first('email');
        if ($email) {
            $user = User::where('email', $email->email)->first();
            $user->password = bcrypt($token['password']);
            $user->save();

            $email = PasswordReset::where('token', $token['token'])->delete();

            if ($user) {
                alert()->success('Thay đổi mật khẩu thành công', 'Vui lòng đăng nhập');
            } else {
                alert()->error('Thay đổi mật khẩu thất bại', 'Vui lòng thử lại');
            }

            return redirect()->route('login.form');
        }
        abort(404);
    }
}
