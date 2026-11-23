<?php

use App\Marketplace\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MarketplaceCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Mobiles' => ['Mobile Phones', 'Tablets', 'Accessories'],
            'Electronics' => ['Computers', 'TVs & Audio', 'Cameras'],
            'Vehicles' => ['Cars', 'Motorcycles', 'Bicycles'],
            'Home & Living' => ['Furniture', 'Appliances', 'Home Decor'],
            'Fashion' => ['Men', 'Women', 'Kids'],
            'Services' => ['Home Services', 'Education', 'Business Services'],
        ];

        foreach ($categories as $parentName => $children) {
            $parent = Category::firstOrCreate(
                ['slug' => Str::slug($parentName)],
                ['name' => $parentName]
            );

            foreach ($children as $childName) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($parentName.'-'.$childName)],
                    ['name' => $childName, 'parent_id' => $parent->id]
                );
            }
        }
    }
}
