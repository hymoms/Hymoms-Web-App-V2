<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class FollowerController extends Controller
{
    
    public function getAll()
    {
        $data = Follower::get();
        return response()->json(['message' => 'Get follower successed', 'data' => $data]);
    }

 

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'follower_id' => 'required',
            'following_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $exist = Follower::where('follower_id', $data['follower_id'])
            ->where('following_id', $data['following_id'])
            ->exists();
        if($exist) return response()->json(['message' => 'this following already exist'], 422);
        $create = Follower::create($data);

        return response()->json(['message' => 'Follower created', 'data' => $data]);
    }

    public function getOneUserFollowing($id)
    {
        if(!is_numeric($id)){
            return response()->json(['message' => 'Please input a valid numeric value'],400);
        }
        // $following = Follower::where('follower_id', $id);
        $following = User::find($id);
        if(!$following) return response()->json(['message' => 'Follower not found'],404);
        return response()->json(['message' => 'Followeing', 'data' => $following->followings]);
    }


    public function delete($id)
    {
        if(!is_numeric($id)){
            return response()->json(['message' => 'Please input a valid numeric value'],400);
        }

        $follower = Follower::find($id);
        if(!$follower) return response()->json(['message' => 'Follower not found'],404);
        $follower->delete();

        return response()->json(['message' => 'Follower deleted', 'data' => $follower]);
    }

    
}
