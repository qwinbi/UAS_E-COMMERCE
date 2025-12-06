<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Bunny Plush Toy',
                'price' => 129000,
                'stock' => 50,
                'description' => 'Soft and cuddly bunny plush toy, perfect for gifts and collections.',
                'category' => 'Toys',
            ],
            [
                'name' => 'Carrot Keychain',
                'price' => 25000,
                'stock' => 100,
                'description' => 'Cute carrot-shaped keychain with bunny charm.',
                'category' => 'Accessories',
            ],
            [
                'name' => 'Bunny Ears Headband',
                'price' => 45000,
                'stock' => 30,
                'description' => 'Adorable bunny ears headband for cosplay or parties.',
                'category' => 'Accessories',
            ],
            [
                'name' => 'Rabbit Pattern T-Shirt',
                'price' => 89000,
                'stock' => 40,
                'description' => 'Comfortable cotton t-shirt with cute rabbit pattern.',
                'category' => 'Clothing',
            ],
            [
                'name' => 'Bunny Mug',
                'price' => 65000,
                'stock' => 60,
                'description' => 'Ceramic mug with bunny design, perfect for morning coffee.',
                'category' => 'Home',
            ],
            [
                'name' => 'Rabbit Notebook',
                'price' => 35000,
                'stock' => 80,
                'description' => 'Cute rabbit-themed notebook for school or work.',
                'category' => 'Stationery',
            ],
            [
                'name' => 'Bunny Sticker Pack',
                'price' => 15000,
                'stock' => 200,
                'description' => 'Set of 50 bunny-themed stickers for decorating.',
                'category' => 'Stationery',
            ],
            [
                'name' => 'Rabbit Socks',
                'price' => 30000,
                'stock' => 70,
                'description' => 'Warm socks with rabbit patterns, perfect for cold days.',
                'category' => 'Clothing',
            ],
            [
                'name' => 'Bunny Phone Case',
                'price' => 55000,
                'stock' => 45,
                'description' => 'Protective phone case with cute bunny design.',
                'category' => 'Accessories',
            ],
            [
                'name' => 'Rabbit Figurine Set',
                'price' => 175000,
                'stock' => 20,
                'description' => 'Set of 3 ceramic rabbit figurines for home decoration.',
                'category' => 'Home',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']) . '-' . Str::random(5),
                'price' => $product['price'],
                'stock' => $product['stock'],
                'description' => $product['description'],
                'image' => 'products/default.png',
                'category' => $product['category'],
            ]);
        }
    }
}