<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class SignUpController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required|string|between:3,100',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:6',
                'confirmPassword' => 'required|same:password|min:6',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['errors' => $validator->errors()],
                422
            );
        }

        User::create(
            array_merge(
                $validator->validated(),
                ['password' => Hash::make($request->password)]
            )
        );

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
