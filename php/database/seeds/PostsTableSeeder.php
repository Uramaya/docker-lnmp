<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Comment;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class, 50)
            ->create()->each(function ($post) {
                factory(Comment::class, 2)->make()->each(function ($comment) use ($post) {
                    $post->comments()->save($comment);
                });
                //            $post->comments()->save(factory(Comment::class)->make());
                //            $comments = factory(App\Comment::class,2)->make();
                //            $post->comments()->saveMany($comments);
            });
    }
}
