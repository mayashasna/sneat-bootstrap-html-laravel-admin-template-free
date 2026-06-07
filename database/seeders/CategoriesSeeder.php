<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name_ar' => 'بيع العقارات', 'name_en' => 'Real Estate Sales'],
            ['name_ar' => 'إيجار العقارات', 'name_en' => 'Real Estate Rentals'],
            ['name_ar' => 'شقق للبيع', 'name_en' => 'Apartments for Sale'],
            ['name_ar' => 'شقق للإيجار', 'name_en' => 'Apartments for Rent'],
            ['name_ar' => 'فلل للبيع', 'name_en' => 'Villas for Sale'],
            ['name_ar' => 'فلل للإيجار', 'name_en' => 'Villas for Rent'],
            ['name_ar' => 'أراضي', 'name_en' => 'Lands'],
            ['name_ar' => 'محلات تجارية', 'name_en' => 'Commercial Shops'],
            ['name_ar' => 'مكاتب تجارية', 'name_en' => 'Office Spaces'],
            ['name_ar' => 'مستودعات', 'name_en' => 'Warehouses'],
            ['name_ar' => 'عقارات صناعية', 'name_en' => 'Industrial Properties'],
            ['name_ar' => 'عقارات زراعية', 'name_en' => 'Agricultural Properties'],
            ['name_ar' => 'إدارة أملاك', 'name_en' => 'Property Management'],
            ['name_ar' => 'تقييم عقاري', 'name_en' => 'Property Valvaluation'],
            ['name_ar' => 'تصوير عقاري', 'name_en' => 'Real Estate Photography'],
            ['name_ar' => 'تصميم داخلي', 'name_en' => 'Interior Design'],
            ['name_ar' => 'ديكور', 'name_en' => 'Decoration'],
            ['name_ar' => 'مقاولات عامة', 'name_en' => 'General Contracting'],
            ['name_ar' => 'مقاولات بناء', 'name_en' => 'Construction Contracting'],
            ['name_ar' => 'ترميم', 'name_en' => 'Renovation'],
            ['name_ar' => 'صيانة عامة', 'name_en' => 'General Maintenance'],
            ['name_ar' => 'صيانة كهرباء', 'name_en' => 'Electrical Maintenance'],
            ['name_ar' => 'صيانة سباكة', 'name_en' => 'Plumbing Maintenance'],
            ['name_ar' => 'صيانة تكييف', 'name_en' => 'AC Maintenance'],
            ['name_ar' => 'صيانة تدفئة', 'name_en' => 'Heating Maintenance'],
            ['name_ar' => 'صيانة مصاعد', 'name_en' => 'Elevator Maintenance'],
            ['name_ar' => 'نجارة', 'name_en' => 'Carpentry'],
            ['name_ar' => 'حدادة', 'name_en' => 'Iron Works'],
            ['name_ar' => 'ألمنيوم', 'name_en' => 'Aluminum Works'],
            ['name_ar' => 'زجاج', 'name_en' => 'Glass Works'],
            ['name_ar' => 'دهانات', 'name_en' => 'Painting'],
            ['name_ar' => 'جبس', 'name_en' => 'Gypsum Works'],
            ['name_ar' => 'بلاط', 'name_en' => 'Tiling'],
            ['name_ar' => 'رخام', 'name_en' => 'Marble Works'],
            ['name_ar' => 'مطابخ', 'name_en' => 'Kitchens'],
            ['name_ar' => 'أثاث', 'name_en' => 'Furniture'],
            ['name_ar' => 'ستائر', 'name_en' => 'Curtains'],
            ['name_ar' => 'إضاءة', 'name_en' => 'Lighting'],
            ['name_ar' => 'أرضيات', 'name_en' => 'Flooring'],
            ['name_ar' => 'أسقف', 'name_en' => 'Ceilings'],
            ['name_ar' => 'حدائق', 'name_en' => 'Landscaping'],
            ['name_ar' => 'مسابح', 'name_en' => 'Swimming Pools'],
            ['name_ar' => 'مكافحة حشرات', 'name_en' => 'Pest Control'],
            ['name_ar' => 'تنظيف عقارات', 'name_en' => 'Property Cleaning'],
            ['name_ar' => 'نقل أثاث', 'name_en' => 'Furniture Moving'],
            ['name_ar' => 'أمن وحراسة', 'name_en' => 'Security Services'],
            ['name_ar' => 'شبكات إنترنت', 'name_en' => 'Internet Networking'],
            ['name_ar' => 'كاميرات مراقبة', 'name_en' => 'CCTV Installation'],
            ['name_ar' => 'خدمات قانونية عقارية', 'name_en' => 'Real Estate Legal Services'],
            ['name_ar' => 'مخططات هندسية', 'name_en' => 'Engineering Blueprints'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                [
                    'name_ar' => $cat['name_ar'],
                    'name_en' => $cat['name_en'],
                ],
                [
                    'is_active' => true,
                ]
            );
        }
    }
}
