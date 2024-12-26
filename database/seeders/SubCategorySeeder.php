<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubCategory;
class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        SubCategory::create(['name' => 'Mobiles', 'slug' => 'mobiles', 'category_id' => 1]);
        SubCategory::create(['name' => 'Laptops', 'slug' => 'laptops', 'category_id' => 1]);
        SubCategory::create(['name' => 'Clothing', 'slug' => 'clothing', 'category_id' => 2]);
        SubCategory::create(['name' => 'Footwear', 'slug' => 'footwear', 'category_id' => 2]);
        SubCategory::create(['name' => 'Furniture', 'slug' => 'furniture', 'category_id' => 3]);
        SubCategory::create(['name' => 'Kitchen Appliances', 'slug' => 'kitchen-appliances', 'category_id' => 3]);
    }
}