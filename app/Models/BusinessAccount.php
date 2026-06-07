<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @mixin IdeHelperBusinessAccount
 */
class BusinessAccount extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $appends = ['documents', 'average_rating', 'ratings_count'];

    protected $hidden = ['media'];

    protected $fillable = [
        'user_id',
        'activity_type_id',
        'city_id',
        'license_number',
        'name_ar',
        'name_en',
        'activities',
        'details',
        'latitude',
        'longitude',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activityType()
    {
        return $this->belongsTo(ActivityType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function receivedRatings()
    {
        return $this->hasMany(ServiceOrderRating::class, 'provider_business_id');
    }

    public function getAverageRatingAttribute()
    {
        if ($this->receivedRatings()->count() === 0) {
            return 0;
        }

        return round($this->receivedRatings()->avg('rating'), 2);
    }

    public function getRatingsCountAttribute()
    {
        return $this->receivedRatings()->count();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('documents')
            ->useDisk('public');
    }

    public function getDocumentsAttribute()
    {
        return $this->getMedia('documents')->map(function ($media) {
            return [
                'id'   => $media->id,
                'url'  => $media->getUrl(),
                'name' => $media->file_name,
                'size' => $media->size,
            ];
        });
    }
}
