<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;

/**
 * Blackseadigital\Partners\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string|null $external_id
 * @property int|null $sort_order
 * @property \October\Rain\Argon\Argon|null $deleted_at
 * @method static \October\Rain\Database\Builder|Category addWhereExistsQuery($query, $boolean = 'and', $not = false)
 * @method static \October\Rain\Database\Collection<int, static> all($columns = ['*'])
 * @method static \October\Rain\Database\Collection<int, static> get($columns = ['*'])
 * @method static \October\Rain\Database\Builder|Category lists($column, $key = null)
 * @method static \October\Rain\Database\Builder|Category newModelQuery()
 * @method static \October\Rain\Database\Builder|Category newQuery()
 * @method static \October\Rain\Database\Builder|Category orSearchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Category orSearchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Category paginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Category paginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Category query()
 * @method static \October\Rain\Database\Builder|Category searchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Category searchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Category simplePaginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Category simplePaginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Category whereDeletedAt($value)
 * @method static \October\Rain\Database\Builder|Category whereExternalId($value)
 * @method static \October\Rain\Database\Builder|Category whereId($value)
 * @method static \October\Rain\Database\Builder|Category whereName($value)
 * @method static \October\Rain\Database\Builder|Category whereSortOrder($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use Validation;
    use Sortable;
    use SoftDelete;

    public $table = 'blackseadigital_partners_categories';

    public array $attributeNames = [
        'name' => 'Name',
        'external_id' => 'External id',
        'sort_order' => 'Sort order',
    ];

    public array $rules = [
        'name' => 'required|string|max:255',
        'external_id' => 'nullable|string|max:255',
        'sort_order' => 'nullable|int',
    ];

    public $fillable = [
        'name',
        'external_id',
        'deleted_at',
        'sort_order',
    ];

    public $timestamps = false;

    public $dates = ['deleted_at'];

    public $hasMany = [
        'partners' => [
            Partner::class,
            'delete' => true,
        ],
    ];
}
