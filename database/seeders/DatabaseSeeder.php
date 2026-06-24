<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StoreSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '08123456789',
            'role' => UserRole::Admin,
        ]);

        // Create Customer
        User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '08123456788',
            'role' => UserRole::Customer,
        ]);

        // Create Categories
        $categories = [
            'Celana Training',
            'Celana Jogger',
            'Celana Pendek',
            'Celana Panjang',
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
            ]);
        }

        // Create Products
        $products = [
            [
                'name' => 'Celana Training Premium',
                'category_id' => 1,
                'price' => 150000,
                'description' => 'Celana training premium dengan bahan polyester berkualitas tinggi. Nyaman digunakan untuk olahraga dan aktivitas sehari-hari.',
            ],
            [
                'name' => 'Celana Jogger Sport',
                'category_id' => 2,
                'price' => 175000,
                'description' => 'Celana jogger sport dengan desain modern. Cocok untuk casual dan olahraga.',
            ],
            [
                'name' => 'Celana Pendek Running',
                'category_id' => 3,
                'price' => 85000,
                'description' => 'Celana pendek running dengan bahan ringan dan breathable. Ideal untuk lari dan gym.',
            ],
            [
                'name' => 'Celana Panjang Futsal',
                'category_id' => 4,
                'price' => 125000,
                'description' => 'Celana panjang futsal dengan bahan elastis dan nyaman. Dirancang khusus untuk olahraga futsal.',
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'category_id' => $productData['category_id'],
                'price' => $productData['price'],
                'description' => $productData['description'],
                'is_active' => true,
            ]);

            // Create variants
            $sizes = ['S', 'M', 'L', 'XL'];
            foreach ($sizes as $size) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'color' => 'Hitam',
                    'stock' => 10,
                ]);
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'color' => 'Navy',
                    'stock' => 5,
                ]);
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'color' => 'Misty',
                    'stock' => 5,
                ]);
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'color' => 'Biru',
                    'stock' => 5,
                ]);
            }
        }

        // Create Store Settings
        StoreSetting::create([
            'store_name' => 'Iwangsport',
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder' => 'Iwangsport',
            'contact' => '08123456789',
            'address' => 'Jl. Sport No. 123, Jakarta',
        ]);
    }
}
