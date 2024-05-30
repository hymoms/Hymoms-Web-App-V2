<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{
    public function createPost() {
        $data = $request->all();
        // $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $create = Post::create($data);

        return response()->json(['message' => 'Post created', 'data' => $data]);
    }

    public function getAllPost() {
        $data = Post::get();
        return response()->json(['message' => 'Get post successed', 'data' => $data]);
    }

    public function getOnePost($id) {
        if(!is_numeric($id)){
            return response()->json(['message' => 'Please input a valid numeric value'],400);
        }
        $post = Post::find($id);
        if(!$post) return response()->json(['message' => 'Post not found'],404);
        return response()->json(['message' => 'Post detail', 'data' => $post]);
    }

    public function updatePost($id) {

    }

    public function deletePost($id) {

    }

    public function addLike() {

    }

    public function deleteLike($id) {

    }

    public function addComment() {

    }

    public function deleteComment($id) {

    }

    public function updateComment($id) {

    }

    
}
