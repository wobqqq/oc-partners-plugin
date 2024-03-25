<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Validation;

class Store extends Model
{
    use Validation;
    use SoftDelete;

    public $table = 'blackseadigital_partners_stores';

    public array $attributeNames = [
        'address' => 'Address',
        'external_id' => 'External id',
        'city_id' => 'Country',
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
        'partner_id' => 'required|int',
    ];

    public $fillable = [
        'external_id',
        'partner_id',
        'city_id',
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
    ];

    public $dates = ['deleted_at'];
}
