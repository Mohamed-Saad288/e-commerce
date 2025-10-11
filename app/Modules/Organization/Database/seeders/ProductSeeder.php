<?php

namespace App\Modules\Organization\Database\seeders;

use App\Modules\Organization\app\Models\Brand\Brand;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\OptionItem\OptionItem;
use App\Modules\Organization\app\Models\Product\Product;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $organizationId = 1;
        $employeeId = 1;

        // Get categories
        $smartphonesCategory = Category::where('slug', 'smartphones')->first();
        $laptopsCategory = Category::where('slug', 'laptops')->first();
        $mensClothingCategory = Category::where('slug', 'mens-clothing')->first();
        $womensClothingCategory = Category::where('slug', 'womens-clothing')->first();
        $shoesCategory = Category::where('slug', 'shoes')->first();

        // Get brands
        $appleBrand = Brand::where('slug', 'apple')->first();
        $samsungBrand = Brand::where('slug', 'samsung')->first();
        $dellBrand = Brand::where('slug', 'dell')->first();
        $nikeBrand = Brand::where('slug', 'nike')->first();
        $adidasBrand = Brand::where('slug', 'adidas')->first();

        // Get option items
        $colorBlack = OptionItem::whereTranslationLike('name', 'black')->first();
        $colorWhite = OptionItem::whereTranslationLike('name', 'white')->first();
        $colorBlue = OptionItem::whereTranslationLike('name', 'blue')->first();
        $colorRed = OptionItem::whereTranslationLike('name', 'red')->first();
        $colorSilver = OptionItem::whereTranslationLike('name', 'silver')->first();
        $colorGold = OptionItem::whereTranslationLike('name', 'gold')->first();

        $storage128 = OptionItem::whereTranslationLike('name', '128gb')->first();
        $storage256 = OptionItem::whereTranslationLike('name', '256gb')->first();
        $storage512 = OptionItem::whereTranslationLike('name', '512gb')->first();

        $ram8gb = OptionItem::whereTranslationLike('name', '8gb')->first();
        $ram16gb = OptionItem::whereTranslationLike('name', '16gb')->first();

        $sizeM = OptionItem::whereTranslationLike('name', 'm')->first();
        $sizeL = OptionItem::whereTranslationLike('name', 'l')->first();
        $sizeXL = OptionItem::whereTranslationLike('name', 'xl')->first();
        $size40 = OptionItem::whereTranslationLike('name', '40')->first();
        $size41 = OptionItem::whereTranslationLike('name', '41')->first();
        $size42 = OptionItem::whereTranslationLike('name', '42')->first();

        $products = [
            // iPhone 15 Pro
            [
                'product' => [
                    'en' => [
                        'name' => 'iPhone 15 Pro',
                        'description' => 'The iPhone 15 Pro features a titanium design, A17 Pro chip, and advanced camera system with 48MP main camera.',
                        'short_description' => 'Latest iPhone with titanium design and A17 Pro chip',
                    ],
                    'ar' => [
                        'name' => 'آيفون 15 برو',
                        'description' => 'يتميز iPhone 15 Pro بتصميم من التيتانيوم وشريحة A17 Pro ونظام كاميرا متقدم بدقة 48 ميجابكسل.',
                        'short_description' => 'أحدث آيفون بتصميم تيتانيوم وشريحة A17 Pro',
                    ],
                    'slug' => 'iphone-15-pro',
                    'brand_id' => $appleBrand->id,
                    'category_id' => $smartphonesCategory->id,
                    'organization_id' => $organizationId,
                    'employee_id' => $employeeId,
                    'type' => 1,
                    'low_stock_threshold' => 5,
                    'requires_shipping' => 1,
                ],
                'variations' => [
                    [
                        'sku' => 'APL-IPH15PRO-128-BLK',
                        'stock_quantity' => 50,
                        'cost_price' => 900,
                        'selling_price' => 1199,
                        'discount' => 0,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 15,
                        'total_price' => 1378.85,
                        'sort_order' => 1,
                        'option_items' => [$colorBlack->id, $storage128->id],
                    ],
                    [
                        'sku' => 'APL-IPH15PRO-256-BLK',
                        'stock_quantity' => 40,
                        'cost_price' => 1000,
                        'selling_price' => 1299,
                        'discount' => 0,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 15,
                        'total_price' => 1493.85,
                        'sort_order' => 2,
                        'option_items' => [$colorBlack->id, $storage256->id],
                    ],
                    [
                        'sku' => 'APL-IPH15PRO-256-SLV',
                        'stock_quantity' => 35,
                        'cost_price' => 1000,
                        'selling_price' => 1299,
                        'discount' => 0,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 15,
                        'total_price' => 1493.85,
                        'sort_order' => 3,
                        'option_items' => [$colorSilver->id, $storage256->id],
                    ],
                ],
            ],
            // Samsung Galaxy S24 Ultra
            [
                'product' => [
                    'en' => [
                        'name' => 'Samsung Galaxy S24 Ultra',
                        'description' => 'Premium Android smartphone with 200MP camera, S Pen support, and powerful Snapdragon processor.',
                        'short_description' => 'Flagship Samsung phone with 200MP camera',
                    ],
                    'ar' => [
                        'name' => 'سامسونج جالاكسي S24 الترا',
                        'description' => 'هاتف أندرويد متميز مع كاميرا 200 ميجابكسل ودعم S Pen ومعالج سناب دراجون قوي.',
                        'short_description' => 'هاتف سامسونج الرائد بكاميرا 200 ميجابكسل',
                    ],
                    'slug' => 'samsung-galaxy-s24-ultra',
                    'brand_id' => $samsungBrand->id,
                    'category_id' => $smartphonesCategory->id,
                    'organization_id' => $organizationId,
                    'employee_id' => $employeeId,
                    'type' => 1,
                    'low_stock_threshold' => 5,
                    'requires_shipping' => 1,
                ],
                'variations' => [
                    [
                        'sku' => 'SAM-S24ULTRA-256-BLK',
                        'stock_quantity' => 45,
                        'cost_price' => 950,
                        'selling_price' => 1249,
                        'discount' => 50,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 15,
                        'total_price' => 1378.85,
                        'sort_order' => 1,
                        'option_items' => [$colorBlack->id, $storage256->id],
                    ],
                    [
                        'sku' => 'SAM-S24ULTRA-512-BLK',
                        'stock_quantity' => 30,
                        'cost_price' => 1050,
                        'selling_price' => 1399,
                        'discount' => 50,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 15,
                        'total_price' => 1551.35,
                        'sort_order' => 2,
                        'option_items' => [$colorBlack->id, $storage512->id],
                    ],
                ],
            ],
            // Dell XPS 15
            [
                'product' => [
                    'en' => [
                        'name' => 'Dell XPS 15',
                        'description' => 'Premium laptop with 15.6" 4K OLED display, Intel Core i7 processor, and NVIDIA graphics.',
                        'short_description' => 'High-performance laptop with 4K OLED display',
                    ],
                    'ar' => [
                        'name' => 'ديل XPS 15',
                        'description' => 'كمبيوتر محمول متميز بشاشة OLED 4K 15.6 بوصة ومعالج إنتل كور i7 ورسومات NVIDIA.',
                        'short_description' => 'كمبيوتر محمول عالي الأداء بشاشة 4K OLED',
                    ],
                    'slug' => 'dell-xps-15',
                    'brand_id' => $dellBrand->id,
                    'category_id' => $laptopsCategory->id,
                    'organization_id' => $organizationId,
                    'employee_id' => $employeeId,
                    'type' => 1,
                    'low_stock_threshold' => 3,
                    'requires_shipping' => 1,
                ],
                'variations' => [
                    [
                        'sku' => 'DELL-XPS15-16GB-512GB',
                        'stock_quantity' => 20,
                        'cost_price' => 1400,
                        'selling_price' => 1899,
                        'discount' => 100,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 15,
                        'total_price' => 2068.85,
                        'sort_order' => 1,
                        'option_items' => [$ram16gb->id, $storage512->id],
                    ],
                ],
            ],
            // Nike Air Max 270
            [
                'product' => [
                    'en' => [
                        'name' => 'Nike Air Max 270',
                        'description' => 'Comfortable running shoes with Air cushioning technology and breathable mesh upper.',
                        'short_description' => 'Running shoes with Air cushioning',
                    ],
                    'ar' => [
                        'name' => 'نايكي اير ماكس 270',
                        'description' => 'أحذية جري مريحة مع تقنية التوسيد Air والجزء العلوي الشبكي القابل للتنفس.',
                        'short_description' => 'أحذية جري مع توسيد Air',
                    ],
                    'slug' => 'nike-air-max-270',
                    'brand_id' => $nikeBrand->id,
                    'category_id' => $shoesCategory->id,
                    'organization_id' => $organizationId,
                    'employee_id' => $employeeId,
                    'type' => 1,
                    'low_stock_threshold' => 10,
                    'requires_shipping' => 1,
                ],
                'variations' => [
                    [
                        'sku' => 'NIKE-AIRMAX270-40-BLK',
                        'stock_quantity' => 30,
                        'cost_price' => 80,
                        'selling_price' => 150,
                        'discount' => 0,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 10,
                        'total_price' => 165,
                        'sort_order' => 1,
                        'option_items' => [$size40->id, $colorBlack->id],
                    ],
                    [
                        'sku' => 'NIKE-AIRMAX270-41-BLK',
                        'stock_quantity' => 35,
                        'cost_price' => 80,
                        'selling_price' => 150,
                        'discount' => 0,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 10,
                        'total_price' => 165,
                        'sort_order' => 2,
                        'option_items' => [$size41->id, $colorBlack->id],
                    ],
                    [
                        'sku' => 'NIKE-AIRMAX270-42-WHT',
                        'stock_quantity' => 25,
                        'cost_price' => 80,
                        'selling_price' => 150,
                        'discount' => 0,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 10,
                        'total_price' => 165,
                        'sort_order' => 3,
                        'option_items' => [$size42->id, $colorWhite->id],
                    ],
                ],
            ],
            [
                'product' => [
                    'en' => [
                        'name' => 'Adidas Ultraboost 22',
                        'description' => 'Premium running shoes with Boost cushioning and Primeknit upper for maximum comfort.',
                        'short_description' => 'Premium running shoes with Boost technology',
                    ],
                    'ar' => [
                        'name' => 'أديداس الترا بوست 22',
                        'description' => 'أحذية جري متميزة مع توسيد Boost والجزء العلوي Primeknit لأقصى راحة.',
                        'short_description' => 'أحذية جري متميزة مع تقنية Boost',
                    ],
                    'slug' => 'adidas-ultraboost-22',
                    'brand_id' => $adidasBrand->id,
                    'category_id' => $shoesCategory->id,
                    'organization_id' => $organizationId,
                    'employee_id' => $employeeId,
                    'type' => 1,
                    'low_stock_threshold' => 10,
                    'requires_shipping' => 1,
                ],
                'variations' => [
                    [
                        'sku' => 'ADIDAS-UB22-40-BLK',
                        'stock_quantity' => 20,
                        'cost_price' => 100,
                        'selling_price' => 180,
                        'discount' => 10,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 10,
                        'total_price' => 187,
                        'sort_order' => 1,
                        'option_items' => [$size40->id, $colorBlack->id],
                    ],
                    [
                        'sku' => 'ADIDAS-UB22-41-BLU',
                        'stock_quantity' => 25,
                        'cost_price' => 100,
                        'selling_price' => 180,
                        'discount' => 10,
                        'is_taxable' => 1,
                        'tax_type' => 2,
                        'tax_amount' => 10,
                        'total_price' => 187,
                        'sort_order' => 2,
                        'option_items' => [$size41->id, $colorBlue->id],
                    ],
                ],
            ],
        ];

        foreach ($products as $productData) {
            // Remove product-level columns that don't exist on the products table (e.g. sku, barcode)
            $productPayload = $productData['product'];

            // Create product (translations are preserved because they're part of the payload)
            $product = Product::create($productPayload);

            // Calculate total stock from variations
            $totalStock = 0;
            foreach ($productData['variations'] as $variationData) {
                $totalStock += $variationData['stock_quantity'];

                $optionItems = $variationData['option_items'];
                unset($variationData['option_items']);

                $variationData['product_id'] = $product->id;
                $variationData['organization_id'] = $organizationId;
                $variationData['employee_id'] = $employeeId;

                $variation = ProductVariation::create($variationData);

                // Sync option items
                $variation->option_items()->sync($optionItems);
            }

            // Update product stock
            $product->update(['stock_quantity' => $totalStock]);
        }
    }
}
