<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Repositories\PostRepository;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create(): void
    {
        //1. define the goal
        //test if create() will actually create a record in the DB
        //2. replicate the env / restriction
        $repository = $this->app->make(PostRepository::class);
        //3. Define the source of truth
        $payload = [
            'title'=> 'this is a test title 1',
            'body'=> []
        ];
        //4. compare the result
        $result =  $repository->create($payload);
        $this->assertSame($payload['title'], $result-> title, "Post created doesn't have the same title");

    }
    public function test_update(): void
    {
        //1. define the goal
        //test if create() will actually create a record in the DB
        //2. replicate the env / restriction
        $repository = $this->app->make(PostRepository::class);
        $dummyPost = Post::factory(1)->create()[0];
        //3. Define the source of truth
        $payload = [
            'title'=> "updated title hhh"
        ];
        //4. compare the result
        $result =  $repository->update($dummyPost, $payload);
        $this->assertSame($dummyPost['title'], $result-> title, "Post created doesn't have the same title");


    }
    public function test_delete(): void
    {
        //1. define the goal
        //test if create() will actually create a record in the DB
        //2. replicate the env / restriction
        $repository = $this->app->make(PostRepository::class);
        $dummyPost = Post::factory(1)->create()[0];
        //3. Define the source of truth
        $payload = [
            'title'=> "updated title hhh"
        ];
        //4. compare the result
        $result =  $repository->update($dummyPost, $payload);
        $this->assertSame($dummyPost['title'], $result-> title, "Post created doesn't have the same title");

    }
}
