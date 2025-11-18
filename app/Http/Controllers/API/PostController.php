<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::paginate(5);
        return response()->json([
            "status" => 1,
            "message" => "Posts fetched successfully",
            "data" => $posts
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => "Validation error",
                "data" => $validator->errors()->all()
            ]);
        }
        $post = Post::create([
            "title" => $request->title,
            "body" => $request->body,
        ]);
        return response()->json([
            "status" => 1,
            "message" => "Post created successfully",
            "data" => $post
        ]);
    }
}
