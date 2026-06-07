<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [

            // 🧱 مقاولات وإنشاءات
            ['ar' => 'مقاولات عامة', 'en' => 'General Contracting'],
            ['ar' => 'مقاولات بناء', 'en' => 'Building Construction'],
            ['ar' => 'مقاولات كهرباء', 'en' => 'Electrical Contracting'],
            ['ar' => 'مقاولات سباكة', 'en' => 'Plumbing Contracting'],
            ['ar' => 'مقاولات تشطيبات', 'en' => 'Finishing Works'],
            ['ar' => 'مقاولات دهان', 'en' => 'Painting Contracting'],
            ['ar' => 'مقاولات جبس', 'en' => 'Gypsum Works'],
            ['ar' => 'مقاولات سيراميك ورخام', 'en' => 'Ceramic & Marble Works'],
            ['ar' => 'مقاولات حدادة', 'en' => 'Metal Works'],
            ['ar' => 'مقاولات نجارة', 'en' => 'Carpentry Works'],
            ['ar' => 'مقاولات زجاج وألمنيوم', 'en' => 'Glass & Aluminum'],
            ['ar' => 'مقاولات واجهات', 'en' => 'Facade Works'],
            ['ar' => 'مقاولات عزل', 'en' => 'Insulation Works'],
            ['ar' => 'مقاولات تكييف وتهوية', 'en' => 'HVAC Contracting'],
            ['ar' => 'مقاولات مصاعد', 'en' => 'Elevator Installation'],
            ['ar' => 'مقاولات أمن وسلامة', 'en' => 'Safety & Security Systems'],

            // 🔧 صيانة وإصلاح
            ['ar' => 'صيانة كهرباء', 'en' => 'Electrical Maintenance'],
            ['ar' => 'صيانة سباكة', 'en' => 'Plumbing Maintenance'],
            ['ar' => 'صيانة تكييف', 'en' => 'AC Maintenance'],
            ['ar' => 'صيانة مصاعد', 'en' => 'Elevator Maintenance'],
            ['ar' => 'صيانة كاميرات', 'en' => 'CCTV Maintenance'],
            ['ar' => 'صيانة أبواب أوتوماتيكية', 'en' => 'Automatic Doors Maintenance'],
            ['ar' => 'صيانة أجهزة منزلية', 'en' => 'Home Appliances Repair'],

            // 🧹 تنظيف وتعقيم
            ['ar' => 'تنظيف منازل', 'en' => 'Home Cleaning'],
            ['ar' => 'تنظيف مباني', 'en' => 'Building Cleaning'],
            ['ar' => 'تنظيف واجهات', 'en' => 'Facade Cleaning'],
            ['ar' => 'تعقيم منازل', 'en' => 'Home Disinfection'],
            ['ar' => 'مكافحة حشرات', 'en' => 'Pest Control'],

            // 🚚 نقل وتجهيز
            ['ar' => 'نقل أثاث', 'en' => 'Furniture Moving'],
            ['ar' => 'تخزين أثاث', 'en' => 'Furniture Storage'],
            ['ar' => 'تجهيزات منزلية', 'en' => 'Home Equipment'],
            ['ar' => 'تجهيزات مكتبية', 'en' => 'Office Equipment'],
            ['ar' => 'تنسيق حدائق', 'en' => 'Landscaping'],
            ['ar' => 'تصميم داخلي', 'en' => 'Interior Design'],
            ['ar' => 'ديكور داخلي', 'en' => 'Interior Decoration'],

            // 🛒 بيع مواد وتجهيزات
            ['ar' => 'مواد بناء', 'en' => 'Building Materials'],
            ['ar' => 'أدوات كهربائية', 'en' => 'Electrical Supplies'],
            ['ar' => 'أدوات صحية', 'en' => 'Sanitary Supplies'],
            ['ar' => 'دهانات', 'en' => 'Paint Supplies'],
            ['ar' => 'سيراميك وبلاط', 'en' => 'Ceramic & Tiles'],
            ['ar' => 'أبواب ونوافذ', 'en' => 'Doors & Windows'],
            ['ar' => 'إضاءة وديكور', 'en' => 'Lighting & Decor'],

            // 🏢 أنشطة عقارية مباشرة
            ['ar' => 'مكتب عقاري', 'en' => 'Real Estate Office'],
            ['ar' => 'وسيط عقاري', 'en' => 'Real Estate Broker'],
            ['ar' => 'إدارة أملاك', 'en' => 'Property Management'],
            ['ar' => 'تسويق عقاري', 'en' => 'Real Estate Marketing'],
            ['ar' => 'تقييم عقاري', 'en' => 'Property Valuation'],
            ['ar' => 'استشارات عقارية', 'en' => 'Real Estate Consulting'],
            ['ar' => 'تطوير عقاري', 'en' => 'Real Estate Development'],
        ];

        foreach ($types as $type) {
            DB::table('activity_types')->insert([
                'name_ar' => $type['ar'],
                'name_en' => $type['en'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
