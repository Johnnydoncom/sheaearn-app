<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sampleBrands = [
            "Mama'S Pride",
            "Oraimo",
            "Dana"
        ];

        foreach ($sampleBrands as $brand){
            Brand::create(['name'=>$brand]);
        }
    }
}
