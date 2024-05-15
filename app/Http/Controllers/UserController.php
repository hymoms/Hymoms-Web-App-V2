<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function getAll()
    {
        $data = User::get();
        return response()->json(['message' => 'Get user successed', 'data' => $data]);
    }

 

    public function store(Request $request)
    {
        $data = $request->all();
        // $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data['password'] = Hash::make($data['password']);
        $exist = User::where('email', $data['email'])->first();
        if($exist) return response()->json(['message' => 'this email already exist'], 422);
        $create = User::create($data);

        if(gettype($data) == 'integer'){
            return response()->json(['message' => 'Email already exist'], 409);
        }
        return response()->json(['message' => 'User created', 'data' => $data]);
    }

    public function getOne($id)
    {
        if(!is_numeric($id)){
            return response()->json(['message' => 'Please input a valid numeric value'],400);
        }
        $user = User::find($id);
        if(!$user) return response()->json(['message' => 'User not found'],404);
        return response()->json(['message' => 'User detail', 'data' => $user]);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'nullable',
            'password' => 'nullable|confirmed|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->filled("password")) {
            $data['password'] = Hash::make($data['password']);
            unset($data['password_confirmation']);
        }

        if(!is_numeric($id)){
            return response()->json(['message' => 'Please input a valid numeric value'],400);
        }

        $user = User::find($id);
        if(!$data) return response()->json(['message' => 'User not found'],404);
        $update = User::where('id',$id)->update($data);

        return response()->json(['message' => 'User detail', 'data' => $data]);
    }

    public function delete($id)
    {
        if(!is_numeric($id)){
            return response()->json(['message' => 'Please input a valid numeric value'],400);
        }

        $user = User::find($id);
        if(!$user) return response()->json(['message' => 'User not found'],404);
        $user->delete();

        return response()->json(['message' => 'User deleted', 'data' => $user]);
    }
}
