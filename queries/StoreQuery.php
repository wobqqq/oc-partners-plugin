<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Queries;

use BlackSeaDigital\Partners\Dto\Filters\StoreFilterDto;
use Blackseadigital\Partners\Models\Partner;
use Blackseadigital\Partners\Models\Store;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use October\Rain\Database\Builder;

final readonly class StoreQuery
{
    public const MAP_PER_PAGE = 10000;
    public const LIST_PER_PAGE = 16;

    public function getFiltered(StoreFilterDto $storeFilterDto): LengthAwarePaginator
    {
        return Store::when(
            !empty($storeFilterDto->partnerId),
            fn(Builder|Store $q) => $q->wherePartnerId($storeFilterDto->partnerId),
        )
            ->when(
                !empty($storeFilterDto->cityIds),
                fn(Builder|Store $q) => $q->whereIn('city_id', $storeFilterDto->cityIds),
            )
            ->when(
                !empty($storeFilterDto->countryIds),
                fn(Builder|Store $q) => $q->whereIn('country_id', $storeFilterDto->countryIds),
            )
            ->whereHas('partner', fn(Builder|Partner $q) => $q
                ->whereIsActive(true)
                ->when(
                    !empty($storeFilterDto->categoryIds),
                    fn(Builder|Partner $q) => $q->whereIn('category_id', $storeFilterDto->categoryIds),
                )
                ->when(!empty($storeFilterDto->isOnline), fn(Builder|Partner $q) => $q->whereIsOnline(true))
                ->when(!empty($storeFilterDto->isOffline), fn(Builder|Partner $q) => $q->whereIsOffline(true))
            )
            ->when(!empty($storeFilterDto->search), fn(Builder|Store $q) => $q
                ->searchWhere($storeFilterDto->search, ['address'])
                ->orSearchWhereRelation($storeFilterDto->search, 'partner', ['name'])
            )
            ->when(
                $storeFilterDto->perPage === self::MAP_PER_PAGE,
                fn(Builder|Store $q) => $q->with(['partner', 'partner.logo']),
            )
            ->orderBy($storeFilterDto->sortBy, $storeFilterDto->sortDirection)
            ->paginate($storeFilterDto->perPage, ['*'], 'page', $storeFilterDto->page);
    }

    public function getFilteredMap(StoreFilterDto $storeFilterDto): string
    {
        $stores = $this->getFiltered($storeFilterDto);
        /** @var Collection $stores */
        $stores = $stores
            ->filter(fn(Store $store) => !empty($store->lat) && !empty($store->lon))
            ->map(fn(Store $store) => [
                'logo' => $store->partner->logo?->getPath(),
                'lat' => $store->lat,
                'lon' => $store->lon,
                'address' => $store->address,
            ]);

        return $stores->toJson();
    }
}
