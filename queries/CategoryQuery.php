<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Queries;

use October\Rain\Database\Builder;
use Blackseadigital\Partners\Models\Category;
use Illuminate\Support\Collection;

final readonly class CategoryQuery
{
    private Builder|Category $category;

    public function __construct()
    {
        $this->category = Category::query();
    }

    /**
     * @return Collection<int, Category>
     */
    public function getFiltered(): Collection
    {
        return $this->category->orderBy('sort_order')->get();
    }
}
