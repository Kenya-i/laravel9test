<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Carbon;

class PostListControllerTest extends TestCase
{
    /** @test */
    public function TOPページでブログ一覧が表示される()
    {
        $post1 = Post::factory()->hasComments(3)->create(['title' => 'ブログのタイトル1']);
        $post2 = Post::factory()->hasComments(5)->create(['title' => 'ブログのタイトル2']);
        Post::factory()->hasComments(1)->create();


        $this->get('/')
            ->assertOk()
            ->assertSee($post1->title)
            ->assertSee($post2->title)
            ->assertSee($post1->user->name)
            ->assertSee($post2->user->name)
            ->assertSee('(3件のコメント)')
            ->assertSee('(5件のコメント)')
            ->assertSeeInOrder([
                '(5件のコメント)',
                '(3件のコメント)',
                '(1件のコメント)'
            ]);
    }

    /** @test */
    public function ブログの一覧で非公開のブログは表示されない()
    {
        $post1 = Post::factory()->closed()->create([
            'title' => 'これは非公開のブログです'
        ]);

        $post2 = Post::factory()->create([
            'title' => 'これは公開済みのブログです'
        ]);

        $this->get('/')
            ->assertDontSee('これは非公開のブログです')
            ->assertSee('これは公開済みのブログです');
    }

    /** @test */
    public function ブログの詳細画面が表示でき、コメントが古い順に表示される() {

        $post = Post::factory()->create();

        Comment::factory()->createMany([
            ['created_at' => now()->sub('2 days'),'name' => 'コメント太郎','post_id' => $post->id],
            ['created_at' => now()->sub('3 days'),'name' => 'コメント次郎','post_id' => $post->id],
            ['created_at' => now()->sub('1 days'),'name' => 'コメント三郎','post_id' => $post->id]
        ]);

        $this->get('posts/'.$post->id)
            ->assertOk()
            ->assertSee($post->title)
            ->assertSee($post->user->name)
            ->assertSeeInOrder(['コメント次郎', 'コメント太郎', 'コメント三郎']);

        
    }

    /** @test */
    public function ブログで非公開のものは詳細画面は表示できない() {
        $post = Post::factory()->closed()->create();

        $this->get('posts/'.$post->id)
        ->assertForbidden();

    }

    /** @test */
    public function クリスマスの日はメリークリスマスと表示される() {
        $post = Post::factory()->create();

        Carbon::setTestNow('2020-12-24');

        $this->get('posts/' . $post->id)
            ->assertOk()
            ->assertDontSee("メリークリスマス!");

        Carbon::setTestNow('2020-12-25');

        $this->get('posts/' . $post->id)
            ->assertOk()
            ->assertSee("メリークリスマス!");
    }

}
