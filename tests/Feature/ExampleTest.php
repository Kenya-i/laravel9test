<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = 'hoge';
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {

        dump($this->user);

        // 準備

        // 実行
        $response = $this->get('/');

        // 検証
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response2()
    {
        // 準備

        // 実行
        $response = $this->get('/');

        // 検証
        $response->assertStatus(200);
    }
}
