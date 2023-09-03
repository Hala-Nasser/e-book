<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;

class ChangePasswordController extends Controller
{
    public function showChangePassword()
    {
        return response()->view('auth.change_password');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->getData();
        if ($data) {
            $admin = $request->user(); //هيك بجيب الcurrent user الي مسجل
            $admin->password = Hash::make($request->new_password);
            $is_saved = $admin->save();
            if($is_saved){
                return response()->json(['message' => "Password changed successfully"], Response::HTTP_OK);
            }
            return response()->json(['message' => "Failed to change password"], Response::HTTP_BAD_REQUEST);
        }
    }
}
