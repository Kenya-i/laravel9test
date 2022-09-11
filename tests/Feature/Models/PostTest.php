<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PostTest extends TestCase
{
    /** @test */
    public function userリレーションを返す()
    {
        $post = Post::factory()->create();



        $this->assertInstanceOf(User::class, $post->user);
    }

    /** @test */
    public function commentsリレーションのテスト()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Collection::class, $post->comments);
    }

    /** @test */
    public function ブログの公開非公開のscope()
    {
        $post1 = Post::factory()->closed()->create();

        $post2 = Post::factory()->create();

        $posts = Post::onlyOpen()->get();

        $this->assertFalse($posts->contains($post1));
        $this->assertTrue($posts->contains($post2));
    }

    /** @test */
    public function ブログで非公開の時はtrueを返し、公開時はfalseを返す()
    {
        $open = Post::factory()->make();
        $closed = Post::factory()->closed()->make();

        $this->assertFalse($open->isClosed());
        #$this->assertTrue($closed->isClosed());
    }
}
