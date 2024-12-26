<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Product::create([
            'name' => 'iPhone 13',
            'slug' => 'iphone-13',
            'photo' => 'admin/images/main_image/samsung-phone-1721043591.jpg',
            'category_id' => 1,
            'sub_category_id' => 1,
        ]);

        Product::create([
            'name' => 'Dell XPS 13',
            'slug' => 'dell-xps-13',
            'photo' => 'admin/images/main_image/samsung-phone-1721043591.jpg',
            'category_id' => 1,
            'sub_category_id' => 2,
        ]);

        Product::create([
            'name' => 'T-shirt',
            'slug' => 't-shirt',
            'photo' => 'admin/images/main_image/samsung-phone-1721043591.jpg',
            'category_id' => 2,
            'sub_category_id' => 3,
        ]);

        Product::create([
            'name' => 'Sneakers',
            'slug' => 'sneakers',
            'photo' => 'admin/images/main_image/samsung-phone-1721043591.jpg',
            'category_id' => 2,
            'sub_category_id' => 4,
        ]);

        Product::create([
            'name' => 'Sofa',
            'slug' => 'sofa',
            'photo' => 'admin/images/main_image/samsung-phone-1721043591.jpg',
            'category_id' => 3,
            'sub_category_id' => 5,
        ]);

        Product::create([
            'name' => 'Blender',
            'slug' => 'blender',
            'photo' => 'admin/images/main_image/samsung-phone-1721043591.jpg',
            'category_id' => 3,
            'sub_category_id' => 6,
        ]);
    }
}