<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Services;

use BlackSeaDigital\Partners\Dto\Models\CategoryModelDto;
use Blackseadigital\Partners\Models\Category;

final class CategoryService
{
    public function create(CategoryModelDto $categoryModelDto): Category
    {
        return Category::create([
            'name' => $categoryModelDto->name,
            'external_id' => $categoryModelDto->externalId,
            'deleted_at' => $categoryModelDto->deletedAt,
        ]);
    }

    public function update(CategoryModelDto $categoryModelDto, Category $category): Category
    {
        $category->update([
            'name' => $categoryModelDto->name,
            'external_id' => $categoryModelDto->externalId,
            'deleted_at' => $categoryModelDto->deletedAt,
        ]);

        return $category;
    }
}
