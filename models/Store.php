<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Validation;

/**
 * Blackseadigital\Partners\Models\Store
 *
 * @property int $id
 * @property string $address
 * @property string|null $lat
 * @property string|null $lon
 * @property string|null $external_id
 * @property int $city_id
 * @property int $country_id
 * @property int $partner_id
 * @property \October\Rain\Argon\Argon|null $deleted_at
 * @method static \October\Rain\Database\Builder|Store addWhereExistsQuery($query, $boolean = 'and', $not = false)
 * @method static \October\Rain\Database\Collection<int, static> all($columns = ['*'])
 * @method static \October\Rain\Database\Collection<int, static> get($columns = ['*'])
 * @method static \October\Rain\Database\Builder|Store lists($column, $key = null)
 * @method static \October\Rain\Database\Builder|Store newModelQuery()
 * @method static \October\Rain\Database\Builder|Store newQuery()
 * @method static \October\Rain\Database\Builder|Store orSearchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Store orSearchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Store paginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Store paginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Store query()
 * @method static \October\Rain\Database\Builder|Store searchWhere($term, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Store searchWhereRelation($term, $relation, $columns = [], $mode = 'all')
 * @method static \October\Rain\Database\Builder|Store simplePaginateAtPage($perPage, $currentPage)
 * @method static \October\Rain\Database\Builder|Store simplePaginateCustom($perPage, $pageName)
 * @method static \October\Rain\Database\Builder|Store whereAddress($value)
 * @method static \October\Rain\Database\Builder|Store whereCityId($value)
 * @method static \October\Rain\Database\Builder|Store whereCountryId($value)
 * @method static \October\Rain\Database\Builder|Store whereDeletedAt($value)
 * @method static \October\Rain\Database\Builder|Store whereExternalId($value)
 * @method static \October\Rain\Database\Builder|Store whereId($value)
 * @method static \October\Rain\Database\Builder|Store whereLat($value)
 * @method static \October\Rain\Database\Builder|Store whereLon($value)
 * @method static \October\Rain\Database\Builder|Store wherePartnerId($value)
 * @mixin \Eloquent
 */
class Store extends Model
{
    use Validation;
    use SoftDelete;

    public $table = 'blackseadigital_partners_stores';

    public array $attributeNames = [
        'address' => 'Address',
        'external_id' => 'External id',
        'city_id' => 'City',
        'country_id' => 'Country',
        'partner_id' => 'Partner',
        'lat' => 'Lat',
        'lon' => 'Lon',
    ];

    public array $rules = [
        'address' => 'required|string|max:255',
        'lat' => 'nullable|string|max:255',
        'lon' => 'nullable|string|max:255',
        'external_id' => 'nullable|string|max:255',
        'city_id' => 'required|int',
        'country_id' => 'required|int',
        'partner_id' => 'required|int',
    ];

    public $fillable = [
        'external_id',
        'partner_id',
        'city_id',
        'country_id',
        'partner',
        'address',
        'lat',
        'lon',
        'deleted_at',
    ];

    public $timestamps = false;

    public $belongsTo = [
        'partner' => [Partner::class],
        'city' => [City::class],
        'country' => [Country::class],
    ];

    public $dates = ['deleted_at'];
}
