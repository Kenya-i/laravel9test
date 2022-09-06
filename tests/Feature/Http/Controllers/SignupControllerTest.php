<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class SignupControllerTest extends TestCase
{
    /** @test */
    public function ユーザー登録画面が開ける()
    {
        $this->get('signup')
            ->assertOk();
    }

    /** @test */
    public function ユーザー登録できる()
    {

        // データ検証
        // DBに保存
        // ログインされてからマイページにリダイレクト

        $validData = [
            'name' => '太郎',
            'email' => 'aaabbb.net',
            'password' => 'hogehoge',
        ];

        $validData = User::factory()->validData();

        $this->post('signup', $validData)
            ->assertOk();

        unset($validData['password']);

        $this->assertDatabaseHas('users', $validData);

        $user = User::firstWhere($validData);
        // $this->assertNotNull($user);

        $this->assertTrue(Hash::check('hogehoge', $user->password));
    }

    /** @test */
    public function 不正なデータではユーザー登録できない()
    {
        $url = 'signup';

        $this->post($url, ['name' => ''])->assertInvalid(['name' => 'The name field is required.']);
        $this->post($url, ['name' => str_repeat('あ', 21)])->assertInvalid(['name' => 'The name must not be greater than 20 characters.']);
        $this->post($url, ['name' => str_repeat('あ', 20)])->assertValid(['name' => 'The name must not be greater than 20 characters.']);
    }
}
