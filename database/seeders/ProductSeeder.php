<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $books = Category::where('name', 'Books')->first();
        $apparel = Category::where('name', 'Apparel')->first();
        $homeGoods = Category::where('name', 'Home Goods')->first();

        if ($electronics) {
            Product::create(['name' => 'Smartphone X', 'description' => 'Latest smartphone with amazing features.', 'price' => 699.99, 'image' => 'smartphone_x.jpg', 'category_id' => $electronics->id, 'stock' => 50]);
            Product::create(['name' => 'Wireless Headphones', 'description' => 'Noise-cancelling headphones with long battery life.', 'price' => 199.99, 'image' => 'headphones.jpg', 'category_id' => $electronics->id, 'stock' => 80]);
        }
        if ($books) {
            Product::create(['name' => 'The Laravel Handbook', 'description' => 'A comprehensive guide to building web applications with Laravel.', 'price' => 35.50, 'image' => 'laravel_book.jpg', 'category_id' => $books->id, 'stock' => 120]);
            Product::create(['name' => 'Sci-Fi Epic Saga', 'description' => 'An enthralling journey through galaxies far, far away.', 'price' => 18.75, 'image' => 'scifi_book.jpg', 'category_id' => $books->id, 'stock' => 90]);
        }
        if ($apparel) {
             Product::create(['name' => 'Classic T-Shirt', 'description' => 'Soft cotton t-shirt, perfect for everyday wear.', 'price' => 15.00, 'image' => 'tshirt.jpg', 'category_id' => $apparel->id, 'stock' => 200]);
        }
        if ($homeGoods) {
             Product::create(['name' => 'Cozy Throw Blanket', 'description' => 'Warm and comfortable blanket for your living room.', 'price' => 45.99, 'image' => 'blanket.jpg', 'category_id' => $homeGoods->id, 'stock' => 75]);
        }
    }
}