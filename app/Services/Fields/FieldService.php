<?php

namespace App\Services\Fields;

use App\Models\Field;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;

class FieldService
{
    /**
     * List fields with optional filters
     */
    public function list(array $filters = [])
    {
        // نرجّع Query Builder بدون get()
        // (الترتيب النهائي يُضاف في الكونترولر: orderBy('id','desc'))
        $query = Field::with('dynamic_fieldable');

        // Filter by binding type
        if (!empty($filters['binding'])) {
            if ($filters['binding'] === 'category') {
                $query->where('dynamic_fieldable_type', Category::class);
            } elseif ($filters['binding'] === 'subcategory') {
                $query->where('dynamic_fieldable_type', Subcategory::class);
            }
        }

        // Filter by specific category
        if (!empty($filters['category_id'])) {
            $query->where('dynamic_fieldable_type', Category::class)
                  ->where('dynamic_fieldable_id', $filters['category_id']);
        }

        // Filter by specific subcategory
        if (!empty($filters['subcategory_id'])) {
            $query->where('dynamic_fieldable_type', Subcategory::class)
                  ->where('dynamic_fieldable_id', $filters['subcategory_id']);
        }

        return $query;
    }

    /**
     * Create new field (+ ربط خياراته إن وُجدت)
     */
    public function create(array $data)
    {
        // نشتغل داخل transaction: إذا فشل أي شي يتراجع الكل
        return DB::transaction(function () use ($data) {

            // 1) افصل بيانات الخيارات عن بيانات الحقل
            $optionsAr = $data['options_ar'] ?? [];
            $optionsEn = $data['options_en'] ?? [];

            // 2) نظّف البيانات قبل إنشاء الحقل
            unset(
                $data['binding_target'],
                $data['category_id'],
                $data['subcategory_id'],
                $data['options_ar'],
                $data['options_en']
            );

            // 3) أنشئ الحقل
            $field = Field::create($data);

            // 4) اربط الخيارات بالحقل (فقط لأنواع الاختيار)
            if (in_array($field->type, ['select', 'checkbox', 'radio'])) {
                foreach ($optionsAr as $i => $valueAr) {
                    $valueAr = trim($valueAr ?? '');
                    $valueEn = trim($optionsEn[$i] ?? '');

                    // تجاهل الصفوف الفارغة تماماً
                    if ($valueAr === '' && $valueEn === '') {
                        continue;
                    }

                    // create() على العلاقة يحط field_id تلقائياً
                    $field->options()->create([
                        'value_ar'  => $valueAr,
                        'value_en'  => $valueEn,
                        'is_active' => 1,
                    ]);
                }
            }

            return $field;
        });
    }

    /**
     * Update existing field
     */
    public function update(Field $field, array $data)
    {
        unset(
            $data['binding_target'],
            $data['category_id'],
            $data['subcategory_id'],
            $data['options_ar'],
            $data['options_en']
        );

        return $field->update($data);
    }

    /**
     * Delete field
     */
    public function delete(Field $field)
    {
        return $field->delete();
    }
}
