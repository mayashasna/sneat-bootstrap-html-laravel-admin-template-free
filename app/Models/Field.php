<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperField
 */
class Field extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'type',
        'is_required',
        'is_filterable',
        'is_active',
        'dynamic_fieldable_id',
        'dynamic_fieldable_type',
    ];

    /**
     * خيارات الحقل (للـ select / radio / checkbox)
     */
    public function options()
    {
        return $this->hasMany(FieldOption::class);
    }

    /**
     * علاقة المورف: هذا الحقل يتبع تصنيف رئيسي أو فرعي
     */
    public function dynamic_fieldable()
{
    return $this->morphTo();
}
public function serviceValues()
{
    return $this->hasMany(ServiceFieldValue::class);
}

}
