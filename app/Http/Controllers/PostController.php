<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $posts = Post::query()->get();
        return new JsonResponse([
            'data' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $postCreated = Post::query()->create([
            'title' => $request->title,
            'body' => $request->body
        ]);
        return new JsonResponse([
            "data" => $postCreated
        ]);
    }

    /**
     * Display the specified resource.
     * @return JsonResponse
     */
    public function show(Post $post)
    {
        return new JsonResponse([
            'data' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @return JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        $postUpdated = $post->update([
            'title' => $request->title ?? $post->title,
            'body' => $request->body ?? $post->body
        ]);
        if (!$postUpdated) {
            return new JsonResponse([
                'errors' => [
                    'failed to update post'
                ]
            ], 400);
        }
        return new JsonResponse([
            "data" => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(Post $post)
    {
        $deleted = $post->forceDelete();
        if(!$deleted){
            return new JsonResponse([
                "errors"=>'failed to delete post'
            ], 400);
        }
        return new JsonResponse([
            'data'=> 'post is deleted successfully'
        ]);
    }
}
