<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Queries;

use BlackSeaDigital\Partners\Dto\Filters\CountryFilterDto;
use Blackseadigital\Partners\Models\City;
use Blackseadigital\Partners\Models\Country;
use Blackseadigital\Partners\Models\Store;
use Illuminate\Support\Collection;
use October\Rain\Database\Builder;

final readonly class CountryQuery
{
    /**
     * @return Collection<int, Country>
     */
    public function getFiltered(CountryFilterDto $countryFilterDto): Collection
    {
        return Country::when((!empty($countryFilterDto->partnerId)), fn(Builder|Country $q) => $q->whereHas(
            'cities',
            fn(Builder|City $q) => $q->whereHas(
                'stores',
                fn(Builder|Store $q) => $q->wherePartnerId($countryFilterDto->partnerId),
            ),
        ))
            ->orderBy($countryFilterDto->sortBy, $countryFilterDto->sortDirection)
            ->get();
    }
}
