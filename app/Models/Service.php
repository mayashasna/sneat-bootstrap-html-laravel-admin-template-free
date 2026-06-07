<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @mixin IdeHelperService
 */
class Service extends Model implements HasMedia
{
    use InteractsWithMedia;
use SoftDeletes;


    protected $fillable = [
        'business_id',
        'category_id',
        'subcategory_id',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'quantity',
        'type',
       'price_usd',
'price_syp',

        'location_text',
        'latitude',
        'longitude',
        'status',

    ];

    // علاقات
    public function business()
    {
        return $this->belongsTo(BusinessAccount::class, 'business_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

   # قيم الحقول الديناميكية (لاحقًا)
    public function fieldValues()
    {
        return $this->hasMany(ServiceFieldValue::class);
    }
    public function favoritedByUsers()
{
    return $this->belongsToMany(
        \App\Models\User::class,
        'service_favorites',
        'service_id',
        'user_id'
    )->withTimestamps();
}

}
