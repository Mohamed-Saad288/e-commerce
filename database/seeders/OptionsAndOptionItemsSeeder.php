<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionsAndOptionItemsSeeder extends Seeder
{
    public function run()
    {
        $locales = ['en', 'ar']; // Add more locales as needed

        // Create sample options
        $options = [
            [
                'name' => 'Color',
                'translations' => [
                    'en' => 'Color',
                    'ar' => 'اللون'
                ]
            ],
            [
                'name' => 'Size',
                'translations' => [
                    'en' => 'Size',
                    'ar' => 'الحجم'
                ]
            ],
            [
                'name' => 'Material',
                'translations' => [
                    'en' => 'Material',
                    'ar' => 'المواد'
                ]
            ],
            [
                'name' => 'Brand',
                'translations' => [
                    'en' => 'Brand',
                    'ar' => 'العلامة التجارية'
                ]
            ],
        ];

        foreach ($options as $optionData) {
            // Insert the main option record
            $optionId = DB::table('options')->insertGetId([
                'organization_id' => 1, // Assuming organization with id 1 exists
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert translations for each locale
            foreach ($locales as $locale) {
                if (isset($optionData['translations'][$locale])) {
                    DB::table('option_translations')->insert([
                        'option_id' => $optionId,
                        'locale' => $locale,
                        'name' => $optionData['translations'][$locale],
                    ]);
                }
            }

            // Create option items for this option
            $this->createOptionItems($optionId, $optionData['name'], $locales);
        }
    }

    private function createOptionItems($optionId, $optionName, $locales)
    {
        $optionItems = [];

        switch (strtolower($optionName)) {
            case 'color':
                $optionItems = [
                    [
                        'name' => 'Red',
                        'translations' => [
                            'en' => 'Red',
                            'ar' => 'أحمر'
                        ]
                    ],
                    [
                        'name' => 'Blue',
                        'translations' => [
                            'en' => 'Blue',
                            'ar' => 'أزرق'
                        ]
                    ],
                    [
                        'name' => 'Green',
                        'translations' => [
                            'en' => 'Green',
                            'ar' => 'أخضر'
                        ]
                    ],
                    [
                        'name' => 'Black',
                        'translations' => [
                            'en' => 'Black',
                            'ar' => 'أسود'
                        ]
                    ],
                    [
                        'name' => 'White',
                        'translations' => [
                            'en' => 'White',
                            'ar' => 'أبيض'
                        ]
                    ],
                ];
                break;

            case 'size':
                $optionItems = [
                    [
                        'name' => 'Small',
                        'translations' => [
                            'en' => 'Small',
                            'ar' => 'صغير'
                        ]
                    ],
                    [
                        'name' => 'Medium',
                        'translations' => [
                            'en' => 'Medium',
                            'ar' => 'متوسط'
                        ]
                    ],
                    [
                        'name' => 'Large',
                        'translations' => [
                            'en' => 'Large',
                            'ar' => 'كبير'
                        ]
                    ],
                    [
                        'name' => 'Extra Large',
                        'translations' => [
                            'en' => 'Extra Large',
                            'ar' => 'كبير جداً'
                        ]
                    ],
                ];
                break;

            case 'material':
                $optionItems = [
                    [
                        'name' => 'Cotton',
                        'translations' => [
                            'en' => 'Cotton',
                            'ar' => 'قطن'
                        ]
                    ],
                    [
                        'name' => 'Silk',
                        'translations' => [
                            'en' => 'Silk',
                            'ar' => 'حرير'
                        ]
                    ],
                    [
                        'name' => 'Wool',
                        'translations' => [
                            'en' => 'Wool',
                            'ar' => 'صوف'
                        ]
                    ],
                    [
                        'name' => 'Leather',
                        'translations' => [
                            'en' => 'Leather',
                            'ar' => 'جلد'
                        ]
                    ],
                ];
                break;

            case 'brand':
                $optionItems = [
                    [
                        'name' => 'Nike',
                        'translations' => [
                            'en' => 'Nike',
                            'ar' => 'نايك'
                        ]
                    ],
                    [
                        'name' => 'Adidas',
                        'translations' => [
                            'en' => 'Adidas',
                            'ar' => 'أديداس'
                        ]
                    ],
                    [
                        'name' => 'Apple',
                        'translations' => [
                            'en' => 'Apple',
                            'ar' => 'أبل'
                        ]
                    ],
                    [
                        'name' => 'Samsung',
                        'translations' => [
                            'en' => 'Samsung',
                            'ar' => 'سامسونج'
                        ]
                    ],
                ];
                break;

            default:
                // Default option items if option name doesn't match
                $optionItems = [
                    [
                        'name' => 'Option 1',
                        'translations' => [
                            'en' => 'Option 1',
                            'ar' => 'الخيار 1'
                        ]
                    ],
                    [
                        'name' => 'Option 2',
                        'translations' => [
                            'en' => 'Option 2',
                            'ar' => 'الخيار 2'
                        ]
                    ],
                ];
                break;
        }

        foreach ($optionItems as $itemData) {
            // Insert the main option item record
            $itemId = DB::table('option_items')->insertGetId([
                'option_id' => $optionId,
                'organization_id' => 1, // Assuming organization with id 1 exists
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert translations for each locale
            foreach ($locales as $locale) {
                if (isset($itemData['translations'][$locale])) {
                    DB::table('option_item_translations')->insert([
                        'option_item_id' => $itemId,
                        'locale' => $locale,
                        'name' => $itemData['translations'][$locale],
                    ]);
                }
            }
        }
    }
}
