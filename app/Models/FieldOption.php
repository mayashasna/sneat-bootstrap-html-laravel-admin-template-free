<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperFieldOption
 */
class FieldOption extends Model
{
    protected $fillable = [
        'field_id',
        'value_ar',
        'value_en',
        'is_active',
    ];

    /**
     * كل خيار ينتمي لحقل واحد
     */
    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
