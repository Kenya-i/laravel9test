<?php

namespace Tests\Feature\Http\Controllers\Mypage;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostManageControllerTest extends TestCase
{
     /** @test */
     public function ゲストはブログを管理できない()
    {
        $loginurl = 'mypage/login';

        // 認証していない場合
        $this->get('mypage/posts')
            ->assertRedirect($loginurl);
    }

    /** @test */
    public function マイページTOPを開ける()
    {
        // 認証している場合
        // $user = User::factory()->create();

        // $this->actingAs($user)
        //     ->get('mypage/posts')
        //     ->assertOk();

        $this->login();

        $this->get('mypage/posts')
        ->assertOk();
    }
}
