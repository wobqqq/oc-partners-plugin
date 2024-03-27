<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;

/**
 * Blackseadigital\Partners\Models\City
 *
 * @property int $id
 * @property string $name
 * @property string|null $external_id
 * @property int $country_id
 * @property int|null $sort_order
 * @property \October\Rain\Argon\Argon|null $deleted_at
 * @method static \October\Rain\Database\Builder|City addWhereExistsQuery($query, $boolean = 'and', $not = false)
 * @method static \October\Rain\Database\Collection<int, static> all($columns = ['*'])
 * @method static \October\Rain\Database\Collection<int, static> get($columns = ['*'])
 * @method static \October\Rain\Database\Builder|City lists($column, $key = null)
 * @method static \October\Rain\Database\Builder|City newModelQuery()
 * @method static \October\Rain\Database\Builder|City newQuery()
 * @method static \October\Rain\Database\Builder|City orSearchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|City orSearchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|City paginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|City paginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|City query()
 * @method static \October\Rain\Database\Builder|City searchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|City searchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|City simplePaginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|City simplePaginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|City whereCountryId($value)
 * @method static \October\Rain\Database\Builder|City whereDeletedAt($value)
 * @method static \October\Rain\Database\Builder|City whereExternalId($value)
 * @method static \October\Rain\Database\Builder|City whereId($value)
 * @method static \October\Rain\Database\Builder|City whereName($value)
 * @method static \October\Rain\Database\Builder|City whereSortOrder($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    use Validation;
    use SoftDelete;
    use Sortable;

    public $table = 'blackseadigital_partners_cities';

    public array $attributeNames = [
        'name' => 'Name',
        'external_id' => 'External id',
        'country_id' => 'Country',
        'sort_order' => 'Sort order',
    ];

    public array $rules = [
        'name' => 'required|string|max:255',
        'external_id' => 'nullable|string|max:255',
        'country_id' => 'required|integer',
        'sort_order' => 'nullable|int',
    ];

    public $fillable = [
        'name',
        'external_id',
        'country_id',
        'deleted_at',
        'sort_order',
    ];

    public $timestamps = false;

    public $belongsTo = ['country' => [Country::class]];

    public $dates = ['deleted_at'];

    public $hasMany = [
        'stores' => [
            Store::class,
            'delete' => true,
        ],
    ];
}
