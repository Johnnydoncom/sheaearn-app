<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Create a size attribute
        Attribute::create([
            'code'          =>  'size',
            'name'          =>  'Size',
            'frontend_type' =>  'select',
            'is_filterable' =>  1,
            'is_required'   =>  1,
        ]);

        // Create a color attribute
        Attribute::create([
            'code'          =>  'color',
            'name'          =>  'Color',
            'frontend_type' =>  'select',
            'is_filterable' =>  1,
            'is_required'   =>  1,
        ]);

        // Create a Product Line attribute
        Attribute::create([
            'code'          =>  'productline',
            'name'          =>  'Product Line',
            'frontend_type' =>  'text',
            'is_filterable' =>  1,
            'is_required'   =>  1,
        ]);

        // Create a Model attribute
        Attribute::create([
            'code'          =>  'model',
            'name'          =>  'Model',
            'frontend_type' =>  'text',
            'is_filterable' =>  1,
            'is_required'   =>  1,
        ]);

        // Create a Production Country attribute
        Attribute::create([
            'code'          =>  'production_country',
            'name'          =>  'Production Country',
            'frontend_type' =>  'select',
            'is_filterable' =>  1,
            'is_required'   =>  1,
        ]);

        // Create a Weight (kg) attribute
        Attribute::create([
            'code'          =>  'weight',
            'name'          =>  'Weight (kg)',
            'frontend_type' =>  'select',
            'is_filterable' =>  1,
            'is_required'   =>  1,
        ]);

        // Create a NAFDAC No. attribute
        Attribute::create([
            'code'          =>  'nafdac',
            'name'          =>  'NAFDAC No.',
            'frontend_type' =>  'text',
            'is_filterable' =>  1,
            'is_required'   =>  1,
        ]);

        // Create a Main Material attribute
        Attribute::create([
            'code'          =>  'main_material',
            'name'          =>  'Main Material',
            'frontend_type' =>  'text',
            'is_filterable' =>  1,
            'is_required'   =>  1,
        ]);

//        // Create a Main Material attribute
//        Attribute::create([
//            'code'          =>  'main_material',
//            'name'          =>  'Main Material',
//            'frontend_type' =>  'text',
//            'is_filterable' =>  1,
//            'is_required'   =>  1,
//        ]);


    }
}
