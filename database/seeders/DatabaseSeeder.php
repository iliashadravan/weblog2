<?php

use App\Article;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(function($user) {
            $user->articles()->saveMany(factory(Article::class, rand(1,6))->make());
        });


//         $this->call(UsersTableSeeder::class);
//        $this->call([
//            UserTableSeeder::class,
//            ArticlesTableSeeder::class,
//        ]);
    }
}
