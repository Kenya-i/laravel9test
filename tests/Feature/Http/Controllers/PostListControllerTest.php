<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;


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
}
