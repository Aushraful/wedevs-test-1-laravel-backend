<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class SignInController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'    => 'required|email',
                'password' => 'required|min:6',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email','password');

        if (!$token = auth()->attempt($credentials))
        {
            return response()->json([
                'message' => 'Email or password invalid'
            ], 422);
        }

        return response()->json([
            'token' => $token,
            'user'  => auth()->user()
        ], 200);
    }
}
