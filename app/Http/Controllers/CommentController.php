<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $comments= Comment::query()->get();
        return new JsonResponse([
            "data"=> $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $created = Comment::query()->create([
            "body"=>$request->body,
            "user_id"=>$request->user_id,
            "post_id"=>$request->post_id
        ]);
        return new JsonResponse([
            'data'=> $created
        ]);
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function show(Comment $comment)
    {
        return new JsonResponse([
            'data'=> $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Comment $comment)
    {
        $updated = $comment->update([
            'body'=> $request->body ?? $comment->body,
            'user_id'=>$request->user_id?? $comment->user_id,
            'post_id'=> $request->post_id?? $comment->post_id,
        ]);
        if(!$updated){
            return new JsonResponse([
                'errors'=>[
                    'failed to update comment!'
                ]
            ], 400);
        }
        return new JsonResponse([
            'data'=> 'comment is updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Comment $comment)
    {
        $deleted = $comment->forceDelete();
        if(!$deleted){
            return new JsonResponse([
                "errors"=>[
                    "failed to delete comment"
                ]
            ],400);
        }
        return new JsonResponse([
            'data'=> 'comment is deleted successfully'
        ]);
    }
}
