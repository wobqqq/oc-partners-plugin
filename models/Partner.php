<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Models;

use Model;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

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
