<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Apple',
            'Samsung',
            'Sony',
            'Nike',
            'Adidas',
            'Dell',
            'HP',
            'Lenovo'
        ];

        foreach ($brands as $brand) {
            Term::create([
                'type' => 'brand',
                'title' => $brand,
            ]);
        }

        // Product Tags
        $productTags = [
            'Smartphones',
            'Laptops',
            'Headphones',
            'Sneakers',
            'Gaming',
            'Cameras',
            'Smartwatches',
            'Home Appliances'
        ];

        foreach ($productTags as $tag) {
            Term::create([
                'type' => 'products_tag',
                'title' => $tag,
            ]);
        }

        // Blog Tags
        $blogTags = [
            'Tech News',
            'Reviews',
            'Tutorials',
            'Lifestyle',
            'Fitness',
            'Business',
            'Startups',
            'E-commerce'
        ];

        foreach ($blogTags as $tag) {
            Term::create([
                'type' => 'blogs_tag',
                'title' => $tag,
            ]);
        }
    }
}
