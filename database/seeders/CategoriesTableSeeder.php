<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            'Health & Beauty' => [
                'Makeup',
                'Fragrances',
                'Hair Care',
                'Personal Care',
                'Oral Care',
                'Health Care'
            ],
            'Home & Office' => [
                'Home & Kitchen',
                'Home & Office Furniture',
                'Office Products',
                'Small Appliances',
                'Large Appliances'
            ],
            'Phone & Tablets ' => [
                'Mobile Phones',
                'Tablets',
                'Mobile Phone Accessories'
            ],
            'Computing' => [
                'Computers' => [
                    'Computer Components',
                    'Data Storage',
                    'External Components',
                    'Laptop Accessories',
                    'Laptops & Desktops',
                    'Monitors',
                    'Networking Products',
                    'Printers',
                    'Scanners',
                    'Servers'
                ],
                'Software' => [
                    'Accounting & Finance',
                    'Antivirus & Security',
                    'Business & Office',
                    "Children's",
                    'Design & Illustration',
                    'Digital Software',
                    'Education & Reference',
                    'Games',
                    'Lifestyle & Hobbies',
                    'Music',
                    'Networking & Servers',
                    'Operating Systems',
                    'Photography',
                    'Productivity',
                    'Programming & Web Development',
                    'Tax Preparation',
                    'Utilities',
                    'Video'
                ],
                'Computer Accessories' => [
                    'Audio & Video Accessories',
                    'Blank DVDs & Discs',
                    'Cable Security Devices',
                    'Cables & Interconnects',
                    'Cleaning & Repair',
                    'Computer Cable Adapters',
                    'Game Hardware',
                    'Hard Drive Accessories',
                    'Input Devices',
                    'Keyboards, Mice & Accessories',
                    'Laptop Accessories',
                    'Memory Card Accessories',
                    'Memory Cards',
                    'Monitor Accessories',
                    'Networking Accessories',
                    'Printer Accessories',
                    'Printer Ink & Toner',
                    'Surge Protectors',
                    'Uninterrupted Power Supply (UPS)',
                    'USB Gadgets',
                    'Video Projector Accessories'
                ]
            ],
            'Electronics' => [
                'Television & Video',
                'Home Audio',
                'Camera & Photo',
                'Generators & Portable Power'
            ],
            "Women's Fashion" => [
                'Clothing',
                'Shoes',
                "Women's Accessories",
                "Women's Watches"
            ],
            "Men's Fashion" => [
                'Clothing',
                'Shoes',
                "Women's Accessories",
                "Women's Watches",
            ],
            "Baby Products" => [
                'Apparel & Accessories',
                'Diapering',
                'Feeding',
                'Baby & Toddler Toys',
                'Gear',
                'Bathing & Skin Care',
                'Potty Training',
                'Safety'
            ],
            "Gaming" => [
                'Playstation',
                'Xbox',
                'Nintendo'
            ],
            "Sporting Goods" => [
                'Cardio Training',
                'Strength Training Equipment',
                'Accessories',
                'Team Sports',
                'Outdoor & Adventure'
            ],
            "Automobile" => [
                'Car Care' => [
                    'Cleaning Kits',
                    'Exterior Care',
                    'Finishing',
                    'Glass Care',
                    'Interior Care',
                    'Solvents',
                    'Tire & Wheel Care',
                    'Tools & Equipment',
                    'Undercoatings'
                ],
                'Car Electronics & Accessories' => [
                    'Car Electronics',
                    'Car Electronics Accessories'
                ],
                'Cars',
                'Lights & Lighting Accessories',
                'Exterior Accessories' => [
                    'Antenna Toppers',
                    'Body Armor',
                    'Bumper Stickers, Decals & Magnets',
                    'Bumpers & Bumper Accessories',
                    'Cargo Management',
                    'Covers',
                    'Deflectors & Shields',
                    'Emblems',
                    'Fender Flares & Trim',
                    'Gas Caps',
                    'Gas Tank Doors',
                    'Grilles & Grille Guards',
                    'Hood Scoops & Vents',
                    'Horns & Accessories'
                ],
                'Oils & Fluids',
                'Interior Accessories',
                'Tyre & Rim' => [
                    'Car, Light Truck & SUV',
                    'Farm & Industrial',
                    'Inflator and guages',
                    'Rims',
                    'Splash guard',
                    'Tyre',
                    'Tyre & Rim Accessories'
                ],
                'Motorcycle & Powersports',
                'Paint & Paint Supplies',
                'Power & Battery',
                'Replacement Parts',
                'RV Parts & Accessories',
                'Tools & Equipment'
            ],
            "Grocery" => [
                'Food Cupboard',
                'Beer, Wine & Spirits',
                'Household Cleaning',
                'Baby Products'
            ],
        ];

        foreach ($categories as $parent => $children){
            $catLevel1 = Category::create(['name' => $parent, 'parent_id'=> null]);

            if(is_array($children)){
                foreach ($children as $p1 => $child1){
                    if(is_array($child1)) {
                        $catLevel2 = Category::create(['name' => $p1, 'parent_id' => $catLevel1->id]);

                        foreach ($child1 as $p2 => $child2) {
                            if(is_array($child2)) {
                                $catLevel3 = Category::create(['name' => $p2, 'parent_id' => $catLevel2->id]);
                                foreach ($child2 as $p3 => $child3) {
                                    if(is_array($child3)) {
                                        $catLevel4 = Category::create(['name' => $p3, 'parent_id' => $catLevel3->id]);
                                    }else{
                                        $catLevel4 = Category::create(['name' => $child3, 'parent_id' => $catLevel3->id]);
                                    }
                                }
                            }else{
                                $catLevel3 = Category::create(['name' => $child2, 'parent_id' => $catLevel2->id]);
                            }
                        }

                    }else{
                        $catLevel2 = Category::create(['name' => $child1, 'parent_id' => $catLevel1->id]);
                    }
                }
            }
        }
    }
}
