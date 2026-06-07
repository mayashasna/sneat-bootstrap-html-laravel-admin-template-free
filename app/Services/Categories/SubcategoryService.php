<?php

namespace App\Services\Categories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Collection;

class SubcategoryService
{
    /**
     * جلب جميع التصنيفات الفرعية
     */
    public function index(): Collection
    {
        return Subcategory::with('category')
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * إنشاء تصنيف فرعي جديد
     */
    public function store(array $data): Subcategory
    {
        // معالجة الحالة
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        return Subcategory::create($data);
    }

    /**
     * تحديث تصنيف فرعي
     */
    public function update(Subcategory $subcategory, array $data): Subcategory
    {
        // معالجة الحالة
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        $subcategory->update($data);
        return $subcategory;
    }

    /**
     * حذف تصنيف فرعي
     */
    public function delete(Subcategory $subcategory): void
    {
        $subcategory->delete();
    }
}
