<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SpecialProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stock = ProductStock::create([
            'regular_price' =>2000,
            'sales_price' => 0,
            'stock_quantity' => 0,
            'manage_stock' => false
        ]);

        $product = Product::create( [
            'title' => 'Share and Earn Bundle',
            'description' => 'The ultimate 101 guide to make N200,000 monthly on share and earn',
            'special' => 1,
            'user_id' => 1,
            'regular_price' => 2000,
            'sales_price' => 0,
            'manage_stock' => false,
            'type' => 'digital',
            'product_type' => 'simple',
            'product_stock_id' => $stock->id
        ]);



        $product
            ->addMediaFromUrl(Storage::url('special-product.png'))
            ->toMediaCollection('featured_image');
    }
}
