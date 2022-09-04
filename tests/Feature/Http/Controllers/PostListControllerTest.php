<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;


class PostListControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function TOPページでブログ一覧が表示される()
    {
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create();



        $this->get('/')
            ->assertOk()
            ->assertSee($post1->title)
            ->assertSee($post2->title);
    }
}
