<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Models;

use Model;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

/**
 * Blackseadigital\Partners\Models\Partner
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property bool $is_active
 * @property bool $is_online
 * @property bool $is_offline
 * @property string|null $external_id
 * @property int $category_id
 * @property string|null $online_points
 * @property string|null $interest_free_installments
 * @property string|null $offline_points
 * @property string|null $link
 * @property \October\Rain\Argon\Argon|null $deleted_at
 * @method static \October\Rain\Database\Builder|Partner addWhereExistsQuery($query, $boolean = 'and', $not = false)
 * @method static \October\Rain\Database\Collection<int, static> all($columns = ['*'])
 * @method static \October\Rain\Database\Collection<int, static> get($columns = ['*'])
 * @method static \October\Rain\Database\Builder|Partner lists($column, $key = null)
 * @method static \October\Rain\Database\Builder|Partner newModelQuery()
 * @method static \October\Rain\Database\Builder|Partner newQuery()
 * @method static \October\Rain\Database\Builder|Partner orSearchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Partner orSearchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Partner paginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Partner paginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Partner query()
 * @method static \October\Rain\Database\Builder|Partner searchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Partner searchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Partner simplePaginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Partner simplePaginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Partner whereCategoryId($value)
 * @method static \October\Rain\Database\Builder|Partner whereDeletedAt($value)
 * @method static \October\Rain\Database\Builder|Partner whereDescription($value)
 * @method static \October\Rain\Database\Builder|Partner whereExternalId($value)
 * @method static \October\Rain\Database\Builder|Partner whereId($value)
 * @method static \October\Rain\Database\Builder|Partner whereInterestFreeInstallments($value)
 * @method static \October\Rain\Database\Builder|Partner whereIsActive($value)
 * @method static \October\Rain\Database\Builder|Partner whereIsOffline($value)
 * @method static \October\Rain\Database\Builder|Partner whereIsOnline($value)
 * @method static \October\Rain\Database\Builder|Partner whereLink($value)
 * @method static \October\Rain\Database\Builder|Partner whereName($value)
 * @method static \October\Rain\Database\Builder|Partner whereOfflinePoints($value)
 * @method static \October\Rain\Database\Builder|Partner whereOnlinePoints($value)
 * @method static \October\Rain\Database\Builder|Partner whereSlug($value)
 * @mixin \Eloquent
 */
class Partner extends Model
{
    use Validation;
    use Sluggable;
    use SoftDelete;

    public $table = 'blackseadigital_partners_partners';

    public array $attributeNames = [
        'name' => 'Name',
        'slug' => 'Slug',
        'external_id' => 'External id',
        'category_id' => 'Category',
        'is_active' => 'Active',
        'is_offline' => 'Offline',
        'is_online' => 'Online',
        'description' => 'Description',
        'offline_points' => 'Offline points',
        'online_points' => 'Online points',
        'interest_free_installments' => 'Interest-free installments',
        'link' => 'Link',
    ];

    public array $slugs = ['slug' => 'name'];

    public array $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'external_id' => 'nullable|string|max:255',
        'category_id' => 'required|integer',
        'is_active' => 'boolean',
        'is_offline' => 'boolean',
        'is_online' => 'boolean',
        'description' => 'nullable|string|max:14000',
        'offline_points' => 'nullable|string|max:255',
        'interest_free_installments' => 'nullable|string|max:255',
        'online_points' => 'nullable|string|max:255',
        'link' => 'nullable|string|max:255',
    ];

    public $fillable = [
        'name',
        'slug',
        'external_id',
        'category_id',
        'is_active',
        'is_offline',
        'is_online',
        'description',
        'offline_points',
        'interest_free_installments',
        'online_points',
        'link',
        'deleted_at',
    ];

    public $casts = [
        'is_active' => 'boolean',
        'is_offline' => 'boolean',
        'is_online' => 'boolean',
    ];

    public $timestamps = false;

    public $hasMany = [
        'stores' => [
            Store::class,
            'delete' => true,
        ],
    ];

    public $belongsTo = ['category' => [Category::class]];

    public $attachOne = ['logo' => File::class];

    public $attachMany = ['banners' => File::class];

    public $dates = ['deleted_at'];
}
