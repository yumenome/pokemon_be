<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(Request $request){
        $validator = validator($request->all(),[
            'name' => 'required | max: 30',
            'email' => 'required | email',
            'password' => 'required| min:5 |confirmed',
            'password_confirmation' => 'required| min:5'
      ]);

            if($validator->fails()) {
                return $validator->errors();
            }
            $user = User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> $request->password,
                'password_confirmation' => $request->password_confirmation,
            ]);
            $token = $user->createToken('main')->plainTextToken;
            // Auth::login($user);
            return response(compact('token', 'user'));
    }

    public function login(Request $request){
        $validator = validator($request->all(),[
            'email' =>  'required | email','exists:user, email',
            'password' => 'required', 'exists:user,password' ,
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        if(!Auth::attempt($request->all())){
            return response([
                'message' => 'Invalid login!'
            ], 422);
        }

            /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response(compact('token', 'user'));
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json([
            'message' => "successfully logout."
        ],200);
    }
}
