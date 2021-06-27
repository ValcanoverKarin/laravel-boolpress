<?php

use Illuminate\Database\Seeder;
use App\Tag;
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Senza glutine',
            'Vegano',
            'Vegetariano',
            'Piatto veloce',
            'Ricetta della nonna'
        ];

        foreach($tags as $tag_name) {
            $new_tag = new Tag();
            $new_tag->name = $tag_name;

            $slug = Str::of($new_tag->name)->slug('-');
            $new_tag->slug = $slug;
            
            $new_tag->save();
        }
    }
}
