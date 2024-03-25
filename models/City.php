<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Validation;

class City extends Model
{
    use Validation;
    use SoftDelete;

    public $table = 'blackseadigital_partners_cities';

    public array $attributeNames = [
        'name' => 'Name',
        'external_id' => 'External id',
        'country_id' => 'Country',
    ];

    public array $rules = [
        'name' => 'required|string|max:255',
        'external_id' => 'nullable|string|max:255',
        'country_id' => 'required|integer',
    ];

    public $fillable = [
        'name',
        'external_id',
        'country_id',
        'deleted_at',
    ];

    public $timestamps = false;

    public $belongsTo = ['country' => [Country::class]];

    public $dates = ['deleted_at'];
}
