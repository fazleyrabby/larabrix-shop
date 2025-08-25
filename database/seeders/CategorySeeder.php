<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fashion
        $fashion = Category::create([
            'title' => 'Fashion',
            'slug'  => Str::slug('Fashion'),
            'parent_id' => null,
        ]);

        Category::create(['title' => 'Men\'s Clothing', 'slug' => Str::slug("Men's Clothing"), 'parent_id' => $fashion->id]);
        Category::create(['title' => 'Women\'s Clothing', 'slug' => Str::slug("Women's Clothing"), 'parent_id' => $fashion->id]);
        Category::create(['title' => 'T-Shirts', 'slug' => Str::slug("T-Shirts"), 'parent_id' => $fashion->id]);
        Category::create(['title' => 'Jeans', 'slug' => Str::slug("Jeans"), 'parent_id' => $fashion->id]);
        Category::create(['title' => 'Shoes', 'slug' => Str::slug("Shoes"), 'parent_id' => $fashion->id]);
        Category::create(['title' => 'Accessories', 'slug' => Str::slug("Accessories"), 'parent_id' => $fashion->id]);

        // Tech Gadgets
        $gadgets = Category::create([
            'title' => 'Tech Gadgets',
            'slug'  => Str::slug('Tech Gadgets'),
            'parent_id' => null,
        ]);

        Category::create(['title' => 'Smartphones', 'slug' => Str::slug('Smartphones'), 'parent_id' => $gadgets->id]);
        Category::create(['title' => 'Smartwatches', 'slug' => Str::slug('Smartwatches'), 'parent_id' => $gadgets->id]);
        Category::create(['title' => 'Tablets', 'slug' => Str::slug('Tablets'), 'parent_id' => $gadgets->id]);
        Category::create(['title' => 'Laptops', 'slug' => Str::slug('Laptops'), 'parent_id' => $gadgets->id]);
        Category::create(['title' => 'Earbuds & Headphones', 'slug' => Str::slug('Earbuds & Headphones'), 'parent_id' => $gadgets->id]);
        Category::create(['title' => 'Gaming Consoles', 'slug' => Str::slug('Gaming Consoles'), 'parent_id' => $gadgets->id]);

        // Home Appliances
        $appliances = Category::create([
            'title' => 'Home Appliances',
            'slug'  => Str::slug('Home Appliances'),
            'parent_id' => null,
        ]);

        Category::create(['title' => 'Refrigerators', 'slug' => Str::slug('Refrigerators'), 'parent_id' => $appliances->id]);
        Category::create(['title' => 'Washing Machines', 'slug' => Str::slug('Washing Machines'), 'parent_id' => $appliances->id]);
        Category::create(['title' => 'Microwaves', 'slug' => Str::slug('Microwaves'), 'parent_id' => $appliances->id]);
        Category::create(['title' => 'Air Conditioners', 'slug' => Str::slug('Air Conditioners'), 'parent_id' => $appliances->id]);
        Category::create(['title' => 'Vacuum Cleaners', 'slug' => Str::slug('Vacuum Cleaners'), 'parent_id' => $appliances->id]);
        Category::create(['title' => 'Water Purifiers', 'slug' => Str::slug('Water Purifiers'), 'parent_id' => $appliances->id]);

        // PC Components
        $pc = Category::create([
            'title' => 'PC Components',
            'slug'  => Str::slug('PC Components'),
            'parent_id' => null,
        ]);

        Category::create(['title' => 'Motherboard', 'slug' => Str::slug('Motherboard'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Processor', 'slug' => Str::slug('Processor'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'RAM', 'slug' => Str::slug('RAM'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Power Supply', 'slug' => Str::slug('Power Supply'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Monitor', 'slug' => Str::slug('Monitor'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Keyboard', 'slug' => Str::slug('Keyboard'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Mouse', 'slug' => Str::slug('Mouse'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'SSD', 'slug' => Str::slug('SSD'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'HDD', 'slug' => Str::slug('HDD'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'PC Case', 'slug' => Str::slug('PC Case'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Cpu Cooler', 'slug' => Str::slug('Cpu Cooler'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Graphics Card', 'slug' => Str::slug('Graphics Card'), 'is_pc_part' => true, 'parent_id' => $pc->id]);
    }
}
