<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Comment management
 * 
 * Api's to handle comment resource
 */
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size?? 10;
        $comments= Comment::query()->paginate($pageSize);
        return  CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     * @return CommentResource
     */
    public function store(Request $request)
    {
        $created = Comment::query()->create([
            "body"=>$request->body,
            "user_id"=>$request->user_id,
            "post_id"=>$request->post_id
        ]);
        return new CommentResource($created);
    }

    /**
     * Display the specified resource.
     * @return CommentResource
     *
     */
    public function show(Comment $comment)
    {
        return new  CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     * @return CommentResource | JsonResponse
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
        return new CommentResource($comment);
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
