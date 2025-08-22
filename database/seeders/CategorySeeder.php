<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fashion
        $fashion = Category::create(['title' => 'Fashion']);
        Category::create(['title' => 'Men\'s Clothing', 'parent_id' => $fashion->id]);
        Category::create(['title' => 'Women\'s Clothing', 'parent_id' => $fashion->id]);
        Category::create(['title' => 'T-Shirts', 'parent_id' => $fashion->id]);
        Category::create(['title' => 'Jeans', 'parent_id' => $fashion->id]);
        Category::create(['title' => 'Shoes', 'parent_id' => $fashion->id]);
        Category::create(['title' => 'Accessories', 'parent_id' => $fashion->id]);

        // Tech Gadgets
        $gadgets = Category::create(['title' => 'Tech Gadgets']);
        Category::create(['title' => 'Smartphones', 'parent_id' => $gadgets->id]);
        Category::create(['title' => 'Smartwatches', 'parent_id' => $gadgets->id]);
        Category::create(['title' => 'Tablets', 'parent_id' => $gadgets->id]);
        Category::create(['title' => 'Laptops', 'parent_id' => $gadgets->id]);
        Category::create(['title' => 'Earbuds & Headphones', 'parent_id' => $gadgets->id]);
        Category::create(['title' => 'Gaming Consoles', 'parent_id' => $gadgets->id]);

        // Home Appliances
        $appliances = Category::create(['title' => 'Home Appliances']);
        Category::create(['title' => 'Refrigerators', 'parent_id' => $appliances->id]);
        Category::create(['title' => 'Washing Machines', 'parent_id' => $appliances->id]);
        Category::create(['title' => 'Microwaves', 'parent_id' => $appliances->id]);
        Category::create(['title' => 'Air Conditioners', 'parent_id' => $appliances->id]);
        Category::create(['title' => 'Vacuum Cleaners', 'parent_id' => $appliances->id]);
        Category::create(['title' => 'Water Purifiers', 'parent_id' => $appliances->id]);


        // Keep your existing PC Parts as is
        $pc = Category::create(['title' => 'PC Components']);

        Category::create(['title' => 'Motherboard', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Processor', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'RAM', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Power Supply', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Monitor', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Keyboard', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Mouse', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'SSD', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'HDD', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'PC Case', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Cpu Cooler', 'is_pc_part' => true, 'parent_id' => $pc->id]);
        Category::create(['title' => 'Graphics Card', 'is_pc_part' => true, 'parent_id' => $pc->id]);
    }
}
