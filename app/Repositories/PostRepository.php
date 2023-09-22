<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\DB;


class PostRepository extends BaseRepository
{
    /**
     * @param array $attributes
     * @return mixed
     * */
    public function create(array $attributes)
    {
        try {
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
        } catch (Exception $e) {
            throw new GeneralJsonException($e->getMessage(), 500);
        }
    }
    /**
     * @param Post $post
     * @param array $attributes
     * @return mixed
     * */
    public function update($post, array $attributes)
    {
        try {
            return DB::transaction(function () use ($post, $attributes) {
                $post->update([
                    'title' => data_get($attributes, 'title') ?? $post->title,
                    'body' => data_get($attributes, "body") ?? $post->body
                ]);
                // updating pivot table
                if ($userIds = data_get($attributes, 'user_ids')) {
                    $post->users()->sync($userIds);
                }
                return $post;
            });
        } catch (Exception $e) {
            throw new GeneralJsonException($e->getMessage(), 500);
        }
    }
    /**
     * @param Post $post
     * @return mixed
     * */
    public function forceDelete($post)
    {
        try{
            return DB::transaction(function () use($post) {
                $deleted = $post->forceDelete();
                // event(new PostDeleted($post));
                return $deleted;
            });
        }catch(Exception $e){
            throw new GeneralJsonException($e->getMessage(), $e->getCode());
        }

    }
}
