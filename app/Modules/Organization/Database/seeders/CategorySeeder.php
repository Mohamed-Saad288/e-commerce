<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\Category\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1; // Adjust based on your organization
        $employeeId = 1;

        $categories = [
            // Electronics
            [
                'en' => ['name' => 'Electronics', 'description' => 'Electronic devices and accessories'],
                'ar' => ['name' => 'الإلكترونيات', 'description' => 'الأجهزة الإلكترونية والإكسسوارات'],
                'slug' => 'electronics',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
                'sort_order' => 1,
                'children' => [
                    [
                        'en' => ['name' => 'Smartphones', 'description' => 'Mobile phones and accessories'],
                        'ar' => ['name' => 'الهواتف الذكية', 'description' => 'الهواتف المحمولة والإكسسوارات'],
                        'slug' => 'smartphones',
                        'sort_order' => 1,
                    ],
                    [
                        'en' => ['name' => 'Laptops', 'description' => 'Portable computers'],
                        'ar' => ['name' => 'أجهزة الكمبيوتر المحمولة', 'description' => 'أجهزة الكمبيوتر المحمولة'],
                        'slug' => 'laptops',
                        'sort_order' => 2,
                    ],
                    [
                        'en' => ['name' => 'Tablets', 'description' => 'Tablet devices'],
                        'ar' => ['name' => 'الأجهزة اللوحية', 'description' => 'الأجهزة اللوحية'],
                        'slug' => 'tablets',
                        'sort_order' => 3,
                    ],
                ],
            ],
            // Fashion
            [
                'en' => ['name' => 'Fashion', 'description' => 'Clothing and fashion accessories'],
                'ar' => ['name' => 'الموضة', 'description' => 'الملابس وإكسسوارات الموضة'],
                'slug' => 'fashion',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
                'sort_order' => 2,
                'children' => [
                    [
                        'en' => ['name' => 'Men\'s Clothing', 'description' => 'Clothing for men'],
                        'ar' => ['name' => 'ملابس رجالية', 'description' => 'ملابس للرجال'],
                        'slug' => 'mens-clothing',
                        'sort_order' => 1,
                    ],
                    [
                        'en' => ['name' => 'Women\'s Clothing', 'description' => 'Clothing for women'],
                        'ar' => ['name' => 'ملابس نسائية', 'description' => 'ملابس للنساء'],
                        'slug' => 'womens-clothing',
                        'sort_order' => 2,
                    ],
                    [
                        'en' => ['name' => 'Shoes', 'description' => 'Footwear for all'],
                        'ar' => ['name' => 'أحذية', 'description' => 'أحذية للجميع'],
                        'slug' => 'shoes',
                        'sort_order' => 3,
                    ],
                ],
            ],
            // Home & Kitchen
            [
                'en' => ['name' => 'Home & Kitchen', 'description' => 'Home appliances and kitchen items'],
                'ar' => ['name' => 'المنزل والمطبخ', 'description' => 'أجهزة المنزل والمطبخ'],
                'slug' => 'home-kitchen',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
                'sort_order' => 3,
                'children' => [
                    [
                        'en' => ['name' => 'Furniture', 'description' => 'Home furniture'],
                        'ar' => ['name' => 'أثاث', 'description' => 'أثاث المنزل'],
                        'slug' => 'furniture',
                        'sort_order' => 1,
                    ],
                    [
                        'en' => ['name' => 'Kitchen Appliances', 'description' => 'Kitchen tools and appliances'],
                        'ar' => ['name' => 'أدوات المطبخ', 'description' => 'أدوات وأجهزة المطبخ'],
                        'slug' => 'kitchen-appliances',
                        'sort_order' => 2,
                    ],
                ],
            ],
            // Sports & Outdoors
            [
                'en' => ['name' => 'Sports & Outdoors', 'description' => 'Sports equipment and outdoor gear'],
                'ar' => ['name' => 'الرياضة والهواء الطلق', 'description' => 'معدات رياضية وأدوات خارجية'],
                'slug' => 'sports-outdoors',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
                'sort_order' => 4,
            ],
            // Books
            [
                'en' => ['name' => 'Books', 'description' => 'Books and reading materials'],
                'ar' => ['name' => 'الكتب', 'description' => 'الكتب ومواد القراءة'],
                'slug' => 'books',
                'organization_id' => $organizationId,
                'employee_id' => $employeeId,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                $childData['organization_id'] = $organizationId;
                $childData['employee_id'] = $employeeId;
                Category::create($childData);
            }
        }
    }
}
