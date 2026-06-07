<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperSubcategory
 */
class Subcategory extends Model
{
    protected $fillable = [
        'category_id',
        'name_ar',
        'name_en',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // علاقة: التصنيف الفرعي ينتمي لتصنيف رئيسي
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * علاقة المورف: التصنيف الفرعي يملك عدة حقول ديناميكية
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
