<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Queries;

use Blackseadigital\Partners\Models\Country;
use Illuminate\Support\Collection;
use October\Rain\Database\Builder;

final readonly class CountryQuery
{
    private Builder|Country $country;

    public function __construct()
    {
        $this->country = Country::query();
    }

    /**
     * @return Collection<int, Country>
     */
    public function getFiltered(): Collection
    {
        return $this->country->orderBy('name')->get();
    }
}
