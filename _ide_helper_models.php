<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name_ar
 * @property string|null $name_en
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperActivityType {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $is_super
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereIsSuper($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin withoutRole($roles, ?string $guard = null)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAdmin {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $admin_id
 * @property int $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRole whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAdminRole {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $activity_type_id
 * @property int|null $city_id
 * @property string|null $license_number
 * @property string $name_ar
 * @property string|null $name_en
 * @property string|null $activities
 * @property string|null $details
 * @property string $latitude
 * @property string $longitude
 * @property string|null $documents
 * @property string $status
 * @property string|null $rejection_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ActivityType $activityType
 * @property-read \App\Models\City|null $city
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereActivities($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereActivityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereRejectionReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BusinessAccount whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBusinessAccount {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $slug
 * @property bool $is_active
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Field> $dynamic_fields
 * @property-read int|null $dynamic_fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subcategory> $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCategory {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $category_id
 * @property int|null $subcategory_id
 * @property int $field_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\Field $field
 * @property-read \App\Models\Subcategory|null $subcategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryField query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryField whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryField whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryField whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryField whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCategoryField {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name_ar
 * @property string|null $name_en
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCity {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $type
 * @property int $is_required
 * @property int $is_filterable
 * @property int $is_active
 * @property int $sort_order
 * @property int|null $dynamic_fieldable_id
 * @property string|null $dynamic_fieldable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $dynamic_fieldable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FieldOption> $options
 * @property-read int|null $options_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereDynamicFieldableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereDynamicFieldableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereIsFilterable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperField {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $field_id
 * @property string $value_ar
 * @property string $value_en
 * @property int $sort_order
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Field $field
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption whereValueAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldOption whereValueEn($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFieldOption {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $guard_name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRole {}
}

namespace App\Models{
/**
 * @property-read \App\Models\BusinessAccount|null $business
 * @property-read \App\Models\Category|null $category
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Subcategory|null $subcategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperService {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $category_id
 * @property string $name_ar
 * @property string $name_en
 * @property string $slug
 * @property bool $is_active
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Field> $dynamic_fields
 * @property-read int|null $dynamic_fields_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSubcategory {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $password
 * @property string|null $otp_code
 * @property \Illuminate\Support\Carbon|null $otp_expires_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $otp_last_sent_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessAccount> $businessAccounts
 * @property-read int|null $business_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $oauthApps
 * @property-read int|null $oauth_apps_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOtpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOtpExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOtpLastSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

