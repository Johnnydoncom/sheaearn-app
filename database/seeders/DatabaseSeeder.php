<?php

namespace Database\Seeders;

use App\CountryData\CountriesTableSeeder;
use App\CountryData\StatesTableSeeder;
use App\CountryData\CitiesTableChunkOneSeeder;
use App\CountryData\CitiesTableChunkOneTwoSeeder;
use App\CountryData\CitiesTableChunkTwoSeeder;
use App\CountryData\CitiesTableChunkTwoTwoSeeder;
use App\CountryData\CitiesTableChunkThreeSeeder;
use App\CountryData\CitiesTableChunkThreeThreeSeeder;
use App\CountryData\CitiesTableChunkFourSeeder;
use App\CountryData\CitiesTableChunkFourFourSeeder;
use App\CountryData\CitiesTableChunkFiveSeeder;
use App\CountryData\CitiesTableChunkFiveFiveSeeder;

use App\Models\Entry;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
//
        $this->call(CitiesTableChunkOneSeeder::class);
        $this->call(CitiesTableChunkOneTwoSeeder::class);

        $this->call(CitiesTableChunkTwoSeeder::class);
        $this->call(CitiesTableChunkTwoTwoSeeder::class);

        $this->call(CitiesTableChunkThreeSeeder::class);
        $this->call(CitiesTableChunkThreeThreeSeeder::class);

        $this->call(CitiesTableChunkFourSeeder::class);
        $this->call(CitiesTableChunkFourFourSeeder::class);

        $this->call(CitiesTableChunkFiveSeeder::class);
        $this->call(CitiesTableChunkFiveFiveSeeder::class);

        $this->call([
            SettingSeeder::class,
            UserTableSeeder::class,
            RolePermissionSeeder::class,
            CategoriesTableSeeder::class,
            BrandsTableSeeder::class,
            TopicsTableSeeder::class,
            PaymentGatewayTableSeeder::class,
            AttributesTableSeeder::class,
            SpecialProductSeeder::class
        ]);

//
//        Product::factory()->count(20)->create()->each(function ($product) {
//            $product->reviews()->createMany(Review::factory()->count(5)->make()->toArray());
//
//            $cat = Category::whereNotNull('parent_id')->get()->random()->id;
//            $product->categories()->sync($cat);
//        });
//
//        Entry::factory()->count(10)->create();


//



//        \Artisan::call('currency:manage add ngn,usd,gbp,cad,aud,sek,inr,cny,eur');
//        \Artisan::call('currency:update -o');
//
//        \DB::table('currencies')->update(['active'=> 1]);

        // \App\Models\User::factory(10)->create();
    }
}
