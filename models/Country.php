<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;

/**
 * Blackseadigital\Partners\Models\Country
 *
 * @property int $id
 * @property string $name
 * @property string|null $external_id
 * @property int|null $sort_order
 * @property \October\Rain\Argon\Argon|null $deleted_at
 * @method static \October\Rain\Database\Builder|Country addWhereExistsQuery($query, $boolean = 'and', $not = false)
 * @method static \October\Rain\Database\Collection<int, static> all($columns = ['*'])
 * @method static \October\Rain\Database\Collection<int, static> get($columns = ['*'])
 * @method static \October\Rain\Database\Builder|Country lists($column, $key = null)
 * @method static \October\Rain\Database\Builder|Country newModelQuery()
 * @method static \October\Rain\Database\Builder|Country newQuery()
 * @method static \October\Rain\Database\Builder|Country orSearchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Country orSearchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Country paginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Country paginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Country query()
 * @method static \October\Rain\Database\Builder|Country searchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Country searchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Country simplePaginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Country simplePaginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Country whereDeletedAt($value)
 * @method static \October\Rain\Database\Builder|Country whereExternalId($value)
 * @method static \October\Rain\Database\Builder|Country whereId($value)
 * @method static \October\Rain\Database\Builder|Country whereName($value)
 * @method static \October\Rain\Database\Builder|Country whereSortOrder($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    use Validation;
    use SoftDelete;
    use Sortable;

    public $table = 'blackseadigital_partners_countries';

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

    public $hasMany = [
        'cities' => [
            City::class,
            'delete' => true,
        ],
    ];

    public $dates = ['deleted_at'];
}
