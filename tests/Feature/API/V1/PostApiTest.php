<?php

namespace Tests\Feature\API\V1;

use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_get_posts_data(): void
    {
        // load data in db
        $posts = Post::factory(10)->create();
        $postIds = $posts->map(fn($post) => $post->id);
        $response = $this->json('get', '/api/v1/posts');
        $data = $response->json('data');
        collect($data)->each(fn($post) => $this->assertTrue(in_array($post["id"], $postIds->toArray())));
    }
    public function test_show_post(): void
    {
        $dummy = Post::factory()->create();
        $response = $this->json('get', '/api/v1/posts/' . $dummy->id);
        $post = $response->assertStatus(200)->json('data');
        $this->assertEquals(data_get($post, 'id'), $dummy->id);
    }

    public function test_create_post(): void
    {
        // Event::fake();
        $dummy = Post::factory()->make();
        $response = $this->json('post', '/api/v1/posts', $dummy->toArray());
        // Event::assertDispatched(PostCreated::class);
        $result = $response->assertStatus(201)->json('data');
        $result = collect($result)->only(array_keys($dummy->getAttributes()));
        $result->each(function ($value, $field) use ($dummy) {
            $this->assertSame(data_get($dummy, $field), $value);
        });

    }
    public function test_update_post(): void
    {
        // Event::fake();
        $dummy = Post::factory()->create();
        $dummy2 = Post::factory()->make();
        //getting all the fields that can be updated(fillable) for the post model
        // $fillable_properties = collect((new Post())->getFillable());
        // //crating a payload from only fillable properties mapped to dummy2
        // $payload = [];
        // $fillable_properties->each(function ($field) use (&$payload, $dummy2) {
        //     $payload[$field] = data_get($dummy2, $field);

        // });
        //sending update request
        $response = $this->json('patch', '/api/v1/posts/' . $dummy->id, $dummy2->toArray());
        // Event::assertDispatched(PostUpdated::class);
        //asserting 200 status
        $result = $response->assertStatus(200)->json('data');
        //taking only fields that were used in payload
        $result = collect($result)->only(array_keys($dummy2->getAttributes()));

        // asserting if the updated value is same as the payload
        $result->each(function($value, $field) use($dummy2){

            $this->assertSame(data_get($dummy2, $field), $value);
            // $this->assertSame(data_get($dummy2, $field), data_get($dummy->refresh(),$field ));
        });
    }
    public function test_post_delete(){
        Event::fake();
        $post = Post::factory()->create();
        $response = $this->json('delete', '/api/v1/posts/'.$post->id);
        // Event::assertDispatched(PostDeleted::class);
        $response->assertStatus(200);

        $this->expectException(ModelNotFoundException::class);
        Post::query()->findOrFail($post->id);

    }
}
