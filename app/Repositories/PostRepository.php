<?php

namespace App\Repositories;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    /**
     * @param array $attributes
     * @return mixed
     * */
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $created = Post::query()->create([
                'title' => data_get($attributes, "title", 'Untitled'),
                'body' => data_get($attributes, 'body')
            ]);
            // pivot table syncing
            if ($userIds = data_get($attributes, 'user_ids')) {
                $created->users()->sync($userIds);
            }
            return $created;
        });
    }
    /**
     * @param Post $post
     * @param array $attributes
     * @return mixed
     * */
    public function update($post, array $attributes)
    {
        return DB::transaction(function () use ($post, $attributes) {
            $updated = $post->update([
                'title' => data_get($attributes, 'title') ?? $post->title,
                'body' => data_get($attributes, "body") ?? $post->body
            ]);
            if (!$updated) {
                throw new \Exception('Failed to update post');
            }
            // updating pivot table
            if ($userIds = data_get($attributes, 'user_ids')) {
                $post->users()->sync($userIds);
            }
            return $post;
        });
    }
    /**
     * @param Post $post
     * @return mixed
     * */
    public function forceDelete($post)
    {
        return DB::transaction(function () use ($post) {
            $deleted = $post->forceDelete();
            if (!$deleted) {
                throw new \Exception('Failed to delete');
            }
            return $deleted;
        });
    }
}
