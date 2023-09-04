<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgetPasswordController extends Controller
{
    public function showForgetPassword(Request $request){
        return response()->view('auth.forget_password');
    }

    public function sendResetEmail(ForgetPasswordRequest $request){
        $validated = $request->getData();

        if($validated){
            $status = Password::sendResetLink($request->only('email'));
            return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)], Response::HTTP_OK)
            : response()->json(['message' => __($status)], Response::HTTP_BAD_REQUEST);
        }
    }

    public function showResetPassword(Request $request, $token) {
        $email = $request['email'];
        return response()->view('auth.reset_password', compact('token', 'email'));
    }

    public function resetPassword(ResetPasswordRequest $request){
        $validated = $request->getData();
        if($validated){
            $status = Password::reset($request->all(), function($user, $password){
                $user->password = Hash::make($password);
                $user->save();

                // $user->forceFill([
                //     'password' => Hash::make($password),
                // ])->setRememberToken(Str::random($60));
                event(new PasswordReset($user));
            });

            return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)], Response::HTTP_OK)
            : response()->json(['message' => __($status)], Response::HTTP_BAD_REQUEST);
        }
    }
}
