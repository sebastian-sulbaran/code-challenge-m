<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\WeatherRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request, $id)
    {

        $user = $request->user();

        $weather_request = WeatherRequest::findOrFail($id);

        if ($weather_request->user_id != $user->id) {
            return response()->json(["status" => "error", "message" => "unauthoraized"], 401);
        }

        $comments = $weather_request->comments;
        $response["data"] = [
            "comments" => $comments->toArray()
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request, $id)
    {
        
        $request->validate([
            'comment' => 'required|string'
        ]);

        $user = $request->user();

        $weather_request = WeatherRequest::findOrFail($id);

        if ($weather_request->user_id != $user->id) {
            return response()->json(["status" => "error", "message" => "unauthoraized"], 401);
        }

        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->parent()->associate($weather_request);
        $comment->user()->associate($user);
        $comment->save();

        $response["data"] = [
            "comments" => $comment
            ];

        return response()->json($response, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $comment = Comment::findOrFail($id);

        if ($comment->user_id != $user->id) {
            return response()->json(["status" => "error", "message" => "unauthoraized"], 401);
        }

        $comment->delete();
        $response['data'] = ""; //use a resourse to map the object 
        return response()->json($response,204);
    }
}
