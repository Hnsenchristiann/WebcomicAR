<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ComicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Author::factory(10)->create();
        \App\Models\Comic::factory(10)->create();
        \App\Models\Page::factory(50)->create();

        $comics = \App\Models\Comic::get();

        foreach($comics as $comic){
            if(str_contains($comic->title, 'Kara')){
                continue;
            }
            $l = \App\Models\Author::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
            $comic->authors()->sync($l);

            $pages = $comic->pages()->get();
            $chapters = [];
            foreach($pages as $page){
                if(!in_array($page->chapter, $chapters, true)){
                    \App\Models\ChapterPreview::create([
                        'comic_id' => $comic->id,
                        'chapter' => $page->chapter,
                        'release_date' => now(),
                        'image_url' => '/storage/media/previews/captain-america-preview.jpg'
                    ]);
                    $chapters[] = $page->chapter;
                }
            }
        }
    }
}
