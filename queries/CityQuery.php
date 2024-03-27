<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Queries;

use BlackSeaDigital\Partners\Dto\Filters\CityFilterDto;
use Blackseadigital\Partners\Models\City;
use Blackseadigital\Partners\Models\Store;
use October\Rain\Database\Builder;
use Illuminate\Support\Collection;

final readonly class CityQuery
{
    /**
     * @return Collection<int, City>
     */
    public function getFiltered(CityFilterDto $cityFilterDto): Collection
    {
        return City::when(
            !empty($cityFilterDto->countryIds),
            fn(Builder|City $q) => $q->whereIn('country_id', $cityFilterDto->countryIds)
        )
            ->when(
                (!empty($cityFilterDto->partnerId)),
                fn(Builder|City $q) => $q->whereHas(
                    'stores',
                    fn(Builder|Store $q) => $q->wherePartnerId($cityFilterDto->partnerId),
                )
            )
            ->orderBy($cityFilterDto->sortBy, $cityFilterDto->sortDirection)
            ->get();
    }
}
