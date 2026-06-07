<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCategoryField
 */
class CategoryField extends Model
{
    protected $table = 'category_field';

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'field_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
