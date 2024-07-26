<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccessTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' =>'required|email,max:255',
            'password' => 'required|string|min:6',
            'device_name' => 'string|max:255',
        ]);
        $user = User::where('email',$request->email)->frist();
        if($user && Hash::check($request->password, $user->password))
        {
            $device_name = $request->post('device_name' , $request->userAgent());
            $token = $user->createToken($device_name);

            return response()->json([
                'code' => 1,
                'token' => $token->plainTextToken ,
                'user' => $user,
            ] , 201);

        }
        return response()->json([
            'code' => 0,
            'message' => 'Invalid User',
        ] , 401);
    }
}
