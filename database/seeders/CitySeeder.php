<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [

            // 🏙️ مدن رئيسية
            ['ar' => 'دمشق', 'en' => 'Damascus'],
            ['ar' => 'ريف دمشق', 'en' => 'Rif Dimashq'],
            ['ar' => 'حلب', 'en' => 'Aleppo'],
            ['ar' => 'حمص', 'en' => 'Homs'],
            ['ar' => 'حماة', 'en' => 'Hama'],
            ['ar' => 'اللاذقية', 'en' => 'Latakia'],
            ['ar' => 'طرطوس', 'en' => 'Tartus'],
            ['ar' => 'درعا', 'en' => 'Daraa'],
            ['ar' => 'السويداء', 'en' => 'As-Suwayda'],
            ['ar' => 'القنيطرة', 'en' => 'Quneitra'],

            // 🏘️ مدن إضافية
            ['ar' => 'إدلب', 'en' => 'Idlib'],
            ['ar' => 'الرقة', 'en' => 'Raqqa'],
            ['ar' => 'دير الزور', 'en' => 'Deir ez-Zor'],
            ['ar' => 'الحسكة', 'en' => 'Hasakah'],
            ['ar' => 'منبج', 'en' => 'Manbij'],
            ['ar' => 'عفرين', 'en' => 'Afrin'],
            ['ar' => 'جبلة', 'en' => 'Jableh'],
            ['ar' => 'بانياس', 'en' => 'Baniyas'],
            ['ar' => 'صافيتا', 'en' => 'Safita'],
            ['ar' => 'مصياف', 'en' => 'Masyaf'],
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name_ar' => $city['ar'],
                'name_en' => $city['en'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
