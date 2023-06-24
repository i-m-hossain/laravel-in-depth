<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 10;
        $posts = Post::query()->paginate($pageSize);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     * @return PostResource
     */
    public function store(Request $request)
    {
        $postCreated = DB::transaction(function() use($request){
            $created = Post::query()->create([
                'title' => $request->title,
                'body' => $request->body
            ]);
            // pivot table syncing
            $created->users()->sync($request->user_ids);
            return $created;
        });
        return new PostResource($postCreated);
    }

    /**
     * Display the specified resource.
     * @return PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     * @return PostResource | JsonResponse
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
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse | JsonResponse
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
