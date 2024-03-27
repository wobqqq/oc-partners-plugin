<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Queries;

use Blackseadigital\Partners\Models\Category;
use Illuminate\Support\Collection;

final readonly class CategoryQuery
{
    /**
     * @return Collection<int, Category>
     */
    public function getFiltered(): Collection
    {
        return Category::orderBy('sort_order')->get();
    }
}
