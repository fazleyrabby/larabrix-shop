<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Term::where('type', 'blogs_tag')->get();
        // Create blogs using factory
        Blog::factory()
            ->count(20)
            ->create()
            ->each(function ($blog) use ($tags) {
                // Pick 1-3 random blog tags
                $randomTags = $tags->random(rand(1, 3))->pluck('id')->toArray();

                // Attach them
                $blog->terms()->attach($randomTags);
            });
    }
}
