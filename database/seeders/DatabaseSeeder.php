<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $me = \App\Models\User::create([
            'name' => 'ppramesi',
            'full_name' => 'Priya Pramesi',
            'email' => 'ppramesi@visi8.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123qweasd'), // password
            'remember_token' => Str::random(10),
            'purchase_history' => '{}',
            'read_history' => '{}',
        ]);
        \App\Models\User::factory(10)->create();
        // \App\Models\Author::factory(10)->create();
        // \App\Models\Comic::factory(10)->create();
        // \App\Models\Page::factory(50)->create();

        // $comics = \App\Models\Comic::get();

        // foreach($comics as $comic){
        //     $l = \App\Models\Author::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
        //     $comic->authors()->sync($l);

        //     $pages = $comic->pages()->get();
        //     $chapters = [];
        //     foreach($pages as $page){
        //         if(!in_array($page->chapter, $chapters, true)){
        //             \App\Models\ChapterPreview::create([
        //                 'comic_id' => $comic->id,
        //                 'chapter' => $page->chapter,
        //                 'release_date' => now(),
        //                 'image_url' => '/storage/media/previews/captain-america-preview.jpg'
        //             ]);
        //             $chapters[] = $page->chapter;
        //         }
        //     }
        // }

        $admin = Role::create(['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrate website']);
        $user = Role::create(['name' => 'user', 'display_name' => 'User', 'description' => 'Regular user']);
        $mod = Role::create(['name' => 'moderator', 'display_name' => 'Moderator', 'description' => 'Moderator user']);

        $me->attachRole($admin);
    }
}
