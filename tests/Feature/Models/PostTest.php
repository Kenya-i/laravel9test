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
}
