<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Queries;

use BlackSeaDigital\Partners\Dto\Filters\CityFilterDto;
use Blackseadigital\Partners\Models\City;
use October\Rain\Database\Builder;
use Illuminate\Support\Collection;

final readonly class CityQuery
{
    private Builder|City $city;

    public function __construct()
    {
        $this->city = City::query();
    }

    /**
     * @return Collection<int, City>
     */
    public function getFiltered(CityFilterDto $cityFilterDto): Collection
    {
        return $this->city
            ->when(
                !empty($cityFilterDto->countryId),
                fn(Builder|City $q) => $q->whereCountryId($cityFilterDto->countryId)
            )
            ->orderBy($cityFilterDto->sortBy, $cityFilterDto->sortDirection)
            ->get();
    }
}
