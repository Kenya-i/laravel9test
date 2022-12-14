<?php

namespace Database\Seeders;

use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Post::factory(30)->create();

        User::factory(15)->create()->each(function ($user) {
            Post::factory(random_int(2, 5))->random()->create(['user_id' => $user])->each(function ($post) {
                Comment::factory(random_int(1, 5))->create(['post_id' => $post]);
            });
        });
    }
}
