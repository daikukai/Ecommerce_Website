<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // --- TEMPORARY DEBUGGING START ---
        $allCategories = Category::all();
        echo "DEBUG: Categories found in DB before Product seeding:\n";
        if ($allCategories->isEmpty()) {
            echo "- No categories found at all!\n";
        } else {
            foreach ($allCategories as $cat) {
                echo "- " . $cat->name . " (ID: " . $cat->id . ")\n";
            }
        }
        echo "--------------------------------------------------\n";
        // --- TEMPORARY DEBUGGING END ---

        $electronics = Category::where('name', 'Electronics')->first();
        $books = Category::where('name', 'Books')->first();
        $apparel = Category::where('name', 'Apparel')->first();
        $homeGoods = Category::where('name', 'Home Goods')->first();

        // IMPORTANT: Add checks to ensure categories were found
        if (!$electronics) {
            echo "Warning: 'Electronics' category not found. Ensure CategorySeeder runs first and creates it.\n";
        }
        if (!$books) {
            echo "Warning: 'Books' category not found. Ensure CategorySeeder runs first and creates it.\n";
        }
        if (!$apparel) {
            echo "Warning: 'Apparel' category not found. Ensure CategorySeeder runs first and creates it.\n";
        }
        if (!$homeGoods) {
            echo "Warning: 'Home Goods' category not found. Ensure CategorySeeder runs first and creates it.\n";
        }


        if ($electronics) {
            Product::create([
                'name' => 'Smartphone X',
                'description' => 'Latest smartphone with amazing features.',
                'price' => 699.99,
                'image_url' => 'images/smartphone.jpg', 
                'category_id' => $electronics->id,
                'stock' => 50
            ]);
            Product::create([
                'name' => 'Wireless Headphones',
                'description' => 'Noise-cancelling headphones with long battery life.',
                'price' => 199.99,
                'image_url' => 'images/headphone.jpg', 
                'category_id' => $electronics->id,
                'stock' => 80
            ]);
        }
        if ($books) {
            Product::create([
                'name' => 'The Laravel Handbook',
                'description' => 'A comprehensive guide to building web applications with Laravel.',
                'price' => 35.50,
                'image_url' => 'images/books.jpg', 
                'category_id' => $books->id,
                'stock' => 120
            ]);
            Product::create([
                'name' => 'Sci-Fi Epic Saga',
                'description' => 'An enthralling journey through galaxies far, far away.',
                'price' => 18.75,
                'image_url' => 'images/sci-fi.jpg', 
                'category_id' => $books->id,
                'stock' => 90
            ]);
        }
        if ($apparel) {
            Product::create([
                'name' => 'Classic T-Shirt',
                'description' => 'Soft cotton t-shirt, perfect for everyday wear.',
                'price' => 15.00,
                'image_url' => 'images/t-shirt.jpg', 
                'category_id' => $apparel->id,
                'stock' => 200
            ]);
            Product::create([
                'name' => 'Denim Jeans (Slim Fit)',
                'description' => 'Classic slim-fit denim jeans made from durable and stretchy material. Ideal for everyday wear.',
                'price' => 59.99,
                'stock' => 150,
                'category_id' => $apparel->id,
                'image_url' => 'images/jeans.jpg' 
            ]);
        }
        if ($homeGoods) {
            Product::create([
                'name' => 'Cozy Throw Blanket',
                'description' => 'Warm and comfortable blanket for your living room.',
                'price' => 45.99,
                'image_url' => 'images/blanket.jpg', 
                'category_id' => $homeGoods->id,
                'stock' => 75
            ]);
            Product::create([
                'name' => 'Smart Coffee Maker',
                'description' => 'Brew your coffee from anywhere with this smart coffee maker. Connects to your phone for scheduled brewing.',
                'price' => 89.99,
                'stock' => 75,
                'category_id' => $homeGoods->id,
                'image_url' => 'images/coffee-maker.jpg' 
            ]);

            Product::create([
                'name' => 'Robotic Vacuum Cleaner',
                'description' => 'Automated vacuum cleaner with intelligent mapping and powerful suction. Keep your floors spotless effortlessly.',
                'price' => 299.00,
                'stock' => 30,
                'category_id' => $homeGoods->id,
                'image_url' => 'images/vacuum.jpg' 
            ]);
        }
    }
}