<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\Brand\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        $brands = [
            // Electronics Brands
            [
                'en' => ['name' => 'Apple', 'description' => 'Premium electronics and technology'],
                'ar' => ['name' => 'أبل', 'description' => 'إلكترونيات وتكنولوجيا متميزة'],
                'slug' => 'apple',
                'sort_order' => 1,
            ],
            [
                'en' => ['name' => 'Samsung', 'description' => 'Innovative electronics and appliances'],
                'ar' => ['name' => 'سامسونج', 'description' => 'إلكترونيات وأجهزة مبتكرة'],
                'slug' => 'samsung',
                'sort_order' => 2,
            ],
            [
                'en' => ['name' => 'Dell', 'description' => 'Computer systems and solutions'],
                'ar' => ['name' => 'ديل', 'description' => 'أنظمة وحلول الكمبيوتر'],
                'slug' => 'dell',
                'sort_order' => 3,
            ],
            [
                'en' => ['name' => 'HP', 'description' => 'Computing and printing solutions'],
                'ar' => ['name' => 'اتش بي', 'description' => 'حلول الحوسبة والطباعة'],
                'slug' => 'hp',
                'sort_order' => 4,
            ],
            [
                'en' => ['name' => 'Lenovo', 'description' => 'Personal computers and technology'],
                'ar' => ['name' => 'لينوفو', 'description' => 'أجهزة كمبيوتر شخصية وتكنولوجيا'],
                'slug' => 'lenovo',
                'sort_order' => 5,
            ],
            // Fashion Brands
            [
                'en' => ['name' => 'Nike', 'description' => 'Sports apparel and footwear'],
                'ar' => ['name' => 'نايكي', 'description' => 'ملابس وأحذية رياضية'],
                'slug' => 'nike',
                'sort_order' => 6,
            ],
            [
                'en' => ['name' => 'Adidas', 'description' => 'Athletic wear and accessories'],
                'ar' => ['name' => 'أديداس', 'description' => 'ملابس رياضية وإكسسوارات'],
                'slug' => 'adidas',
                'sort_order' => 7,
            ],
            [
                'en' => ['name' => 'Zara', 'description' => 'Fashion clothing and accessories'],
                'ar' => ['name' => 'زارا', 'description' => 'ملابس وإكسسوارات الموضة'],
                'slug' => 'zara',
                'sort_order' => 8,
            ],
            [
                'en' => ['name' => 'H&M', 'description' => 'Modern fashion for everyone'],
                'ar' => ['name' => 'اتش اند ام', 'description' => 'موضة عصرية للجميع'],
                'slug' => 'hm',
                'sort_order' => 9,
            ],
            [
                'en' => ['name' => 'Levi\'s', 'description' => 'Denim and casual wear'],
                'ar' => ['name' => 'ليفايز', 'description' => 'جينز وملابس كاجوال'],
                'slug' => 'levis',
                'sort_order' => 10,
            ],
            // Home & Kitchen Brands
            [
                'en' => ['name' => 'IKEA', 'description' => 'Furniture and home accessories'],
                'ar' => ['name' => 'ايكيا', 'description' => 'أثاث وإكسسوارات منزلية'],
                'slug' => 'ikea',
                'sort_order' => 11,
            ],
            [
                'en' => ['name' => 'Philips', 'description' => 'Home appliances and lighting'],
                'ar' => ['name' => 'فيليبس', 'description' => 'أجهزة منزلية وإضاءة'],
                'slug' => 'philips',
                'sort_order' => 12,
            ],
            [
                'en' => ['name' => 'Tefal', 'description' => 'Kitchen cookware and appliances'],
                'ar' => ['name' => 'تيفال', 'description' => 'أدوات طهي وأجهزة مطبخ'],
                'slug' => 'tefal',
                'sort_order' => 13,
            ],
            // Generic Brand
            [
                'en' => ['name' => 'Generic', 'description' => 'Quality products at affordable prices'],
                'ar' => ['name' => 'عام', 'description' => 'منتجات عالية الجودة بأسعار معقولة'],
                'slug' => 'generic',
                'sort_order' => 14,
            ],
        ];

        foreach ($brands as $brandData) {
            $brandData['organization_id'] = $organizationId;
            $brandData['employee_id'] = $employeeId;
            Brand::create($brandData);
        }
    }
}
