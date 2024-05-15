<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function login(Request $request){

        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            $user = User::where('email',$data['email'])->first();
            return response()->json([
                'message' => 'Succesfully Login',
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);


        // $email = $data['email'];
        // $password = $data['password'];
        // $user = User::where('email',$email)->first();
        // if (! $user || ! Hash::check($password, $user->password)) {
        //     return response()->json(['message' => 'The provided credentials are incorrect.'],401);
        // }
        // $token = $user->createToken($user->email, ['user-detail'])->plainTextToken;
        
        // return response()->json(['message' => 'Successfully login', 'data' => $user]);
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Succesfully logout', 'data' => $user]);
    }

    public function login_first(Request $request){
        return response()->json(['message' => 'You logged out, login first']);
    }
}
