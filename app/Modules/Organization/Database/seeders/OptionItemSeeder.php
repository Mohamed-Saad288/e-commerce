<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\Option\Option;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;
use Illuminate\Database\Seeder;

class OptionItemSeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        // Color option items
        $colorOption = Option::whereTranslationLike('name', 'Color')->first();
        if ($colorOption) {
            $colors = [
                ['en' => ['name' => 'Black'], 'ar' => ['name' => 'أسود']],
                ['en' => ['name' => 'White'], 'ar' => ['name' => 'أبيض']],
                ['en' => ['name' => 'Red'], 'ar' => ['name' => 'أحمر']],
                ['en' => ['name' => 'Blue'], 'ar' => ['name' => 'أزرق']],
                ['en' => ['name' => 'Green'], 'ar' => ['name' => 'أخضر']],
                ['en' => ['name' => 'Yellow'], 'ar' => ['name' => 'أصفر']],
                ['en' => ['name' => 'Gray'], 'ar' => ['name' => 'رمادي']],
                ['en' => ['name' => 'Silver'], 'ar' => ['name' => 'فضي']],
                ['en' => ['name' => 'Gold'], 'ar' => ['name' => 'ذهبي']],
                ['en' => ['name' => 'Pink'], 'ar' => ['name' => 'وردي']],
            ];

            foreach ($colors as $color) {
                $color['option_id'] = $colorOption->id;
                $color['organization_id'] = $organizationId;
                $color['employee_id'] = $employeeId;
                OptionItem::create($color);
            }
        }

        // Size option items
        $sizeOption = Option::whereTranslationLike('name', 'Size')->first();
        if ($sizeOption) {
            $sizes = [
                ['en' => ['name' => 'XS'], 'ar' => ['name' => 'صغير جداً']],
                ['en' => ['name' => 'S'], 'ar' => ['name' => 'صغير']],
                ['en' => ['name' => 'M'], 'ar' => ['name' => 'متوسط']],
                ['en' => ['name' => 'L'], 'ar' => ['name' => 'كبير']],
                ['en' => ['name' => 'XL'], 'ar' => ['name' => 'كبير جداً']],
                ['en' => ['name' => 'XXL'], 'ar' => ['name' => 'كبير جداً جداً']],
                ['en' => ['name' => '38'], 'ar' => ['name' => '38']],
                ['en' => ['name' => '39'], 'ar' => ['name' => '39']],
                ['en' => ['name' => '40'], 'ar' => ['name' => '40']],
                ['en' => ['name' => '41'], 'ar' => ['name' => '41']],
                ['en' => ['name' => '42'], 'ar' => ['name' => '42']],
                ['en' => ['name' => '43'], 'ar' => ['name' => '43']],
                ['en' => ['name' => '44'], 'ar' => ['name' => '44']],
            ];

            foreach ($sizes as $size) {
                $size['option_id'] = $sizeOption->id;
                $size['organization_id'] = $organizationId;
                $size['employee_id'] = $employeeId;
                OptionItem::create($size);
            }
        }

        // Storage option items
        $storageOption = Option::whereTranslationLike('name', 'Storage')->first();
        if ($storageOption) {
            $storages = [
                ['en' => ['name' => '64GB'], 'ar' => ['name' => '64 جيجابايت']],
                ['en' => ['name' => '128GB'], 'ar' => ['name' => '128 جيجابايت']],
                ['en' => ['name' => '256GB'], 'ar' => ['name' => '256 جيجابايت']],
                ['en' => ['name' => '512GB'], 'ar' => ['name' => '512 جيجابايت']],
                ['en' => ['name' => '1TB'], 'ar' => ['name' => '1 تيرابايت']],
                ['en' => ['name' => '2TB'], 'ar' => ['name' => '2 تيرابايت']],
            ];

            foreach ($storages as $storage) {
                $storage['option_id'] = $storageOption->id;
                $storage['organization_id'] = $organizationId;
                $storage['employee_id'] = $employeeId;
                OptionItem::create($storage);
            }
        }

        // Material option items
        $materialOption = Option::whereTranslationLike('name', 'Material')->first();
        if ($materialOption) {
            $materials = [
                ['en' => ['name' => 'Cotton'], 'ar' => ['name' => 'قطن']],
                ['en' => ['name' => 'Polyester'], 'ar' => ['name' => 'بوليستر']],
                ['en' => ['name' => 'Leather'], 'ar' => ['name' => 'جلد']],
                ['en' => ['name' => 'Denim'], 'ar' => ['name' => 'دنيم']],
                ['en' => ['name' => 'Wool'], 'ar' => ['name' => 'صوف']],
                ['en' => ['name' => 'Silk'], 'ar' => ['name' => 'حرير']],
            ];

            foreach ($materials as $material) {
                $material['option_id'] = $materialOption->id;
                $material['organization_id'] = $organizationId;
                $material['employee_id'] = $employeeId;
                OptionItem::create($material);
            }
        }

        // RAM option items
        $ramOption = Option::whereTranslationLike('name', 'Ram')->first();
        if ($ramOption) {
            $rams = [
                ['en' => ['name' => '4GB'], 'ar' => ['name' => '4 جيجابايت']],
                ['en' => ['name' => '8GB'], 'ar' => ['name' => '8 جيجابايت']],
                ['en' => ['name' => '16GB'], 'ar' => ['name' => '16 جيجابايت']],
                ['en' => ['name' => '32GB'], 'ar' => ['name' => '32 جيجابايت']],
                ['en' => ['name' => '64GB'], 'ar' => ['name' => '64 جيجابايت']],
            ];

            foreach ($rams as $ram) {
                $ram['option_id'] = $ramOption->id;
                $ram['organization_id'] = $organizationId;
                $ram['employee_id'] = $employeeId;
                OptionItem::create($ram);
            }
        }
    }
}
