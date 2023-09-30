<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostSharedNotification;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\URL;
use Notification;

/**
 * @group Post management
 * 
 * Api's to handle post resource
 */
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
     * @param PostStoreRequest $request
     * @return PostResource
     */
    public function store(PostStoreRequest $request, PostRepository $repository)
    {

        $created = $repository->create($request->only([
            'title',
            'body',
            'user_ids'
        ]));
        return new PostResource($created);
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
    public function update(Request $request, Post $post, PostRepository $repository)
    {
        $post = $repository->update($post, $request->only([
            'title',
            'body',
            'user_ids'
        ]));
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse | JsonResponse
     */
    public function destroy(Post $post, PostRepository $repository)
    {
        $post = $repository->forceDelete($post);
        return new JsonResponse([
            'data' => 'success'
        ]);
    }

    /**
     * Share a specified post
     * @response 200{
     *      data: 'http://www.example.com/post'
     * }
     * @param \App\Models\Post $post
     * @return JsonResponse
     */
    public function share(Request $request, Post $post)
    {
        $url = URL::temporarySignedRoute('shared.post', now()->addDays(30), [
            'post' => $post->id
        ]);
        //Way 1:
        $users = User::query()->whereIn('id', $request->user_ids)->get();
        // sending notification
        Notification::send($users, new PostSharedNotification($post, $url));

        // Way 2:
        $user = User::query()->find(1);
        $user->notify(new PostSharedNotification($post, $url));
        
        return new JsonResponse([
            'data' => $url
        ]);
    }
}