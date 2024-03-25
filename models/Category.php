<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;

class Category extends Model
{
    use Validation;
    use Sortable;
    use SoftDelete;

    public $table = 'blackseadigital_partners_categories';

    public array $attributeNames = [
        'name' => 'Name',
        'external_id' => 'External id',
    ];

    public array $rules = [
        'name' => 'required|string|max:255',
        'external_id' => 'nullable|string|max:255',
    ];

    public $fillable = [
        'name',
        'external_id',
        'deleted_at',
    ];

    public $timestamps = false;

    public $dates = ['deleted_at'];
}
