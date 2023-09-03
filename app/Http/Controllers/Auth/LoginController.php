<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function showLogin()
    {
        // if (Auth::guard('admin')->check()) {
        //     return redirect('home');
        // }
        return response()->view('auth.login');

    }

    public function login(LoginRequest $request){
        $loggedIn = Auth::guard('admin')->attempt($request->only(['email','password']), $request['remember']);
        if($loggedIn){
            return response()->json(['message'=>"Logined successfully"], Response::HTTP_OK);
        }
        return response()->json(['message'=>"Email or password not correct"], Response::HTTP_UNAUTHORIZED);
    }
}
