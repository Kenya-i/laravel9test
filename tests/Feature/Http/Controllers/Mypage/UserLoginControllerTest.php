<?php

namespace Tests\Feature\Http\Controllers\Mypage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginControllerTest extends TestCase
{
    /** @test */
    public function ログイン画面を開ける()
    {
        $this->get('mypage/login')
        ->assertOk();
    }

    /** @test */
    public function ログイン時の入力チェック() {
        $url = 'mypage/login';

        $this->from($url)->post($url, [])
        ->assertRedirect($url);

        app()->setLocale('testing');

        $this->post($url, ['email' => ''])->assertInvalid(['email' => 'The email field is required.']);
        $this->post($url, ['email' => 'aa@bb@cc'])->assertInvalid(['email' => 'email']);
        $this->post($url, ['password' => ''])->assertInvalid(['password' => 'password']);
    }
}
