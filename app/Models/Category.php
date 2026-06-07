<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // علاقة: التصنيف الرئيسي يملك عدة تصنيفات فرعية
    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }

    /**
     * علاقة المورف: التصنيف الرئيسي يملك عدة حقول ديناميكية
     */
   public function dynamic_fields()
{
    return $this->morphMany(Field::class, 'dynamic_fieldable');
}
public function fields()
{
    return $this->morphMany(Field::class, 'dynamic_fieldable');
}

}
