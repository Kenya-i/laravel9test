<?php

namespace Tests\Feature\Http\Controllers\Mypage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class UserLoginControllerTest extends TestCase
{
    /** @test */
    public function ログイン画面を開ける()
    {
        $this->get('mypage/login')
            ->assertOk();
    }

    /** @test */
    public function ログイン時の入力チェック()
    {
        $url = 'mypage/login';

        $this->from($url)->post($url, [])
            ->assertRedirect($url);

        app()->setLocale('testing');

        $this->post($url, ['email' => ''])->assertInvalid(['email' => 'The email field is required.']);
        $this->post($url, ['email' => 'aa@bb@cc'])->assertInvalid(['email' => 'email']);
        $this->post($url, ['password' => ''])->assertInvalid(['password' => 'password']);
    }

    /** @test */
    public function ログインできる()
    {
        $url = 'mypage/login';

        $user = User::factory()->create([
            'email' => 'aaa@bbb.ccc',
            'password' => \Hash::make('abcd1234')
        ]);

        $this->post($url, [
            'email' => 'aaa@bbb.ccc',
            'password' => 'abcd1234'
        ])->assertRedirect('mypage/posts');

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function パスワードを間違えているのでログインできず、適切なエラーメッセージが表示されない()
    {
        $url = 'mypage/login';

        $user = User::factory()->create([
            'email' => 'aaa@bbb.ccc',
            'password' => \Hash::make('abcd1234')
        ]);

        $this->from($url)->post($url, [
            'email' => 'aaa@bbb.ccc',
            'password' => '11112222'
        ])->assertRedirect($url);

        $this->get($url)
            ->assertOk()
            ->assertSee('メールアドレスまたはパスワードが間違っています。');
    }

    /** @test */
    public function 認証エラーなのでvalidationExceptionの例外が発生する()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);
        $this->post('mypage/login', [])
            ->assertRedirect();
    }

    /** @test */
    public function 認証OKなのでvalidationExceptionの例外が発生しない()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'email' => 'aaa@bbb.ccc',
            'password' => \Hash::make('abcd1234')
        ]);

        try {
            $this->post('mypage/login', [
                'email' => 'aaa@bbb.ccc',
                'password' => 'abcd1234'
            ])->assertRedirect();
        } catch (ValidationException $e) {
            $this->fail('例外が発生してしまいました');
        }
    }

    /** @test */
    public function ログアウトできる()
    {
        $this->login();

        $this->post('mypage/logout')
        ->assertRedirect('mypage/login');

        $this->get('mypage/login')
        ->assertSee('ログアウトできました');

        #$this->assertGuest();
    }
}
