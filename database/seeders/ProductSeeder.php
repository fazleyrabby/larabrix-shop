<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Database\Seeders\AttributeSeeder;
use Database\Seeders\AttributeValueSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory()->count(50)->create();
        // $products = getDummyProducts();
        // $data = array_map(function($product){
        //     $product['created_at'] = now();
        //     $product['updated_at'] = now();
        //     return $product;
        // }, $products);

        // Product::insert($data);

        if (Attribute::count() === 0) {
            $this->call(AttributeSeeder::class);
            $this->call(AttributeValueSeeder::class);
        }

        $attributes = Attribute::with('values')->take(2)->get();

        // 📦 Create some fashion categories
        $fashionCategories = Category::whereIn('title', [
            'T-Shirts',
            'Jeans',
            'Shoes',
            'Jackets',
            'Watches'
        ])->pluck('id', 'title');

        // 📱 Create some gadget categories
        $gadgetCategories = Category::whereIn('title', [
            'Smartphones',
            'Tablets',
            'Smartwatches',
            'Headphones'
        ])->pluck('id', 'title');

        // 🏠 Create some home appliance categories
        $applianceCategories = Category::whereIn('title', [
            'Refrigerators',
            'Washing Machines',
            'Microwave Ovens',
            'Vacuum Cleaners'
        ])->pluck('id', 'title');

        // 👉 Create 5 simple fashion products
        Product::factory()
            ->count(5)
            ->simple()
            ->create([
                'category_id' => $fashionCategories->random(),
            ]);

        // 👉 Create 5 simple gadget products
        Product::factory()
            ->count(5)
            ->simple()
            ->create([
                'category_id' => $gadgetCategories->random(),
            ]);

        // 👉 Create 5 variable fashion products with variants
        Product::factory()
            ->count(5)
            ->variable()
            ->create([
                'category_id' => $fashionCategories->random(),
            ])
            ->each(function ($product) use ($attributes) {
                $combinations = collect([[]]);

                foreach ($attributes as $attribute) {
                    $values = $attribute->values;
                    $combinations = $combinations->flatMap(function ($combo) use ($values) {
                        return $values->map(function ($value) use ($combo) {
                            return array_merge($combo, [$value->id]);
                        });
                    });
                }

                foreach ($combinations as $valueIds) {
                    $variant = ProductVariant::factory()->create([
                        'product_id' => $product->id,
                    ]);
                    $variant->attributeValues()->attach($valueIds);
                }
            });

        // 👉 Create 5 variable gadget products with variants
        Product::factory()
            ->count(5)
            ->variable()
            ->create([
                'category_id' => $gadgetCategories->random(),
            ])
            ->each(function ($product) use ($attributes) {
                $combinations = collect([[]]);

                foreach ($attributes as $attribute) {
                    $values = $attribute->values;
                    $combinations = $combinations->flatMap(function ($combo) use ($values) {
                        return $values->map(function ($value) use ($combo) {
                            return array_merge($combo, [$value->id]);
                        });
                    });
                }

                foreach ($combinations as $valueIds) {
                    $variant = ProductVariant::factory()->create([
                        'product_id' => $product->id,
                    ]);
                    $variant->attributeValues()->attach($valueIds);
                }
            });

        

        $categories = Category::where('is_pc_part', true)->pluck('id', 'title');
        $now = Carbon::now();
        DB::table('products')->insert([
            [
                'title' => 'AMD Ryzen 5 5600X',
                'sku' => 'CPU-AMD-5600X',
                'slug' => Str::slug('AMD Ryzen 5 5600X'),
                'price' => 299.00,
                'image' => 'https://placehold.co/400x400/FF0000/FFFFFF?text=AMD+5600X',
                'description' => 'A high-performance 6-core processor for gamers and creators.',
                'short_description' => '6-core, 12-thread desktop processor with a base clock speed of 3.7GHz.',
                'additional_info' => json_encode(['Socket' => 'AM4', 'Cores' => 6, 'Threads' => 12]),
                'category_id' => $categories['Processor'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => 'AM4',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Gigabyte B550 AORUS Elite',
                'sku' => 'MB-GIGA-B550',
                'slug' => Str::slug('Gigabyte B550 AORUS Elite'),
                'price' => 159.99,
                'image' => 'https://placehold.co/400x400/0000FF/FFFFFF?text=B550+AORUS',
                'description' => 'An ATX motherboard with a robust power design for AMD Ryzen processors.',
                'short_description' => 'AM4 socket, PCIe 4.0 support, and dual NVMe M.2 slots.',
                'additional_info' => json_encode(['Form Factor' => 'ATX', 'Chipset' => 'B550']),
                'category_id' => $categories['Motherboard'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 2,
                'compatibility_key' => 'AM4',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Corsair Vengeance RGB Pro 16GB',
                'sku' => 'RAM-CORS-16GB',
                'slug' => Str::slug('Corsair Vengeance RGB Pro 16GB'),
                'price' => 79.99,
                'image' => 'https://placehold.co/400x400/FFFF00/000000?text=Vengeance+RAM',
                'description' => 'High-performance DDR4 RAM with dynamic multi-zone RGB lighting.',
                'short_description' => 'DDR4, 3200MHz speed, 16GB (2 x 8GB).',
                'additional_info' => json_encode(['Speed' => '3200MHz', 'Capacity' => '16GB']),
                'category_id' => $categories['RAM'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => 'DDR4',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Corsair RM750x 750W',
                'sku' => 'PSU-CORS-RM750X',
                'slug' => Str::slug('Corsair RM750x 750W'),
                'price' => 129.99,
                'image' => 'https://placehold.co/400x400/00FF00/000000?text=RM750x',
                'description' => 'Fully modular 80+ Gold certified power supply.',
                'short_description' => '750W, fully modular, high efficiency PSU.',
                'additional_info' => json_encode(['Wattage' => '750W', 'Efficiency' => '80+ Gold']),
                'category_id' => $categories['Power Supply'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => '',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Dell UltraSharp 27" Monitor',
                'sku' => 'MON-DELL-U2723Q',
                'slug' => Str::slug('Dell UltraSharp 27 Monitor'),
                'price' => 449.99,
                'image' => 'https://placehold.co/400x400/FF00FF/FFFFFF?text=Dell+U2723Q',
                'description' => '27-inch 4K UHD IPS monitor with HDR support.',
                'short_description' => '4K UHD, IPS, 60Hz, HDR10 support.',
                'additional_info' => json_encode(['Size' => '27"', 'Resolution' => '3840x2160']),
                'category_id' => $categories['Monitor'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 2,
                'compatibility_key' => '',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Logitech MX Keys Keyboard',
                'sku' => 'KB-LOGI-MXKEYS',
                'slug' => Str::slug('Logitech MX Keys Keyboard'),
                'price' => 99.99,
                'image' => 'https://placehold.co/400x400/AAAAAA/000000?text=MX+Keys',
                'description' => 'Wireless keyboard with smart illumination.',
                'short_description' => 'Wireless, USB-C charging, backlit keys.',
                'additional_info' => json_encode(['Type' => 'Wireless', 'Connection' => 'Bluetooth/USB']),
                'category_id' => $categories['Keyboard'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 3,
                'compatibility_key' => '',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Logitech MX Master 3 Mouse',
                'sku' => 'MOUSE-LOGI-MX3',
                'slug' => Str::slug('Logitech MX Master 3'),
                'price' => 79.99,
                'image' => 'https://placehold.co/400x400/CCCCCC/000000?text=MX+Master+3',
                'description' => 'Ergonomic wireless mouse for productivity.',
                'short_description' => 'Wireless, rechargeable, precision sensor.',
                'additional_info' => json_encode(['Type' => 'Wireless', 'DPI' => 4000]),
                'category_id' => $categories['Mouse'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 3,
                'compatibility_key' => '',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Samsung 1TB 970 EVO Plus SSD',
                'sku' => 'SSD-SAMS-1TB',
                'slug' => Str::slug('Samsung 1TB 970 EVO Plus'),
                'price' => 129.99,
                'image' => 'https://placehold.co/400x400/FFFFFF/000000?text=970+EVO+Plus',
                'description' => 'High-speed NVMe M.2 SSD with excellent reliability.',
                'short_description' => '1TB, NVMe PCIe Gen3, up to 3500MB/s read speed.',
                'additional_info' => json_encode(['Capacity' => '1TB', 'Interface' => 'NVMe M.2']),
                'category_id' => $categories['SSD'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => '',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Seagate 2TB HDD',
                'sku' => 'HDD-SEAG-2TB',
                'slug' => Str::slug('Seagate 2TB HDD'),
                'price' => 59.99,
                'image' => 'https://placehold.co/400x400/000000/FFFFFF?text=2TB+HDD',
                'description' => 'Reliable 2TB hard disk drive for storage expansion.',
                'short_description' => '2TB, 7200RPM, SATA 6Gb/s.',
                'additional_info' => json_encode(['Capacity' => '2TB', 'RPM' => 7200]),
                'category_id' => $categories['HDD'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 2,
                'compatibility_key' => '',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'NZXT H510 PC Case',
                'sku' => 'CASE-NZXT-H510',
                'slug' => Str::slug('NZXT H510 PC Case'),
                'price' => 69.99,
                'image' => 'https://placehold.co/400x400/FF8800/000000?text=H510',
                'description' => 'Compact mid-tower case with clean design.',
                'short_description' => 'ATX, tempered glass side panel, cable management.',
                'additional_info' => json_encode(['Form Factor' => 'ATX']),
                'category_id' => $categories['PC Case'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 3,
                'compatibility_key' => '',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Cooler Master Hyper 212 CPU Cooler',
                'sku' => 'COOLER-CM-H212',
                'slug' => Str::slug('Cooler Master Hyper 212'),
                'price' => 39.99,
                'image' => 'https://placehold.co/400x400/00FFFF/000000?text=H212',
                'description' => 'Efficient air cooler for CPUs.',
                'short_description' => 'Tower cooler, 4 heat pipes, PWM fan.',
                'additional_info' => json_encode(['Type' => 'Air Cooler']),
                'category_id' => $categories['Cpu Cooler'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 2,
                'compatibility_key' => '',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'NVIDIA RTX 3060 Graphics Card',
                'sku' => 'GPU-NVIDIA-3060',
                'slug' => Str::slug('NVIDIA RTX 3060'),
                'price' => 399.99,
                'image' => 'https://placehold.co/400x400/8800FF/FFFFFF?text=RTX+3060',
                'description' => 'High-performance gaming GPU.',
                'short_description' => '12GB GDDR6, PCIe 4.0, ray tracing support.',
                'additional_info' => json_encode(['Memory' => '12GB GDDR6']),
                'category_id' => $categories['Graphics Card'],
                'type' => 'simple',
                'is_pc_component' => true,
                'brand_id' => 1,
                'compatibility_key' => '',
                'configurable' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

    }
}
