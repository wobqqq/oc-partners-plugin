<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Queries;

use BlackSeaDigital\Partners\Dto\Filters\StoreFilterDto;
use Blackseadigital\Partners\Enums\QueryListMode;
use Blackseadigital\Partners\Models\City;
use Blackseadigital\Partners\Models\Partner;
use Blackseadigital\Partners\Models\Store;
use October\Rain\Database\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class StoreQuery
{
    private Builder|Store $store;

    public function __construct()
    {
        $this->store = Store::query();
    }

    /**
     * @return LengthAwarePaginator<int, Store>
     */
    public function getFiltered(StoreFilterDto $storeFilterDto): LengthAwarePaginator
    {
        $query = $this->store
            ->when(
                !empty($storeFilterDto->partnerId),
                fn(Builder|Store $q) => $q->wherePartnerId($storeFilterDto->partnerId),
            )
            ->when(
                !empty($storeFilterDto->cityId),
                fn(Builder|Store $q) => $q->whereCityId($storeFilterDto->cityId),
            )
            ->when(!empty($storeFilterDto->countryId), fn(Builder|Store $q) => $q
                ->whereHas('city', fn(Builder|City $q) => $q->whereId($storeFilterDto->countryId))
            )
            ->whereHas('partner', fn(Builder|Partner $q) => $q
                ->whereIsActive(true)
                ->when(
                    !empty($storeFilterDto->categoryId),
                    fn(Builder|Partner $q) => $q->whereCategoryId($storeFilterDto->categoryId),
                )
                ->when($storeFilterDto->isOnline, fn(Builder|Partner $q) => $q->whereIsOnline(true))
                ->when($storeFilterDto->isOffline, fn(Builder|Partner $q) => $q->whereIsOffline(true))
            )
            ->when(!empty($storeFilterDto->search), fn(Builder|Store $q) => $q
                ->searchWhere($storeFilterDto->search, ['address'])
                ->orSearchWhereRelation($storeFilterDto->search, 'partner', ['name'])
            );

        $total = $query->count();
        $offset = ($storeFilterDto->page - 1) * $storeFilterDto->perPage;
        $page = $storeFilterDto->page;
        $perPage = $storeFilterDto->perPage;

        if ($storeFilterDto->mode === QueryListMode::ALL->value) {
            $query->with(['partner', 'partner.logo']);
            $page = 1;
            $perPage = $total === 0 ? $storeFilterDto->perPage : $total;
        }

        $items = $query->orderBy($storeFilterDto->sortBy, $storeFilterDto->sortDirection)
            ->skip($offset)
            ->take($perPage)
            ->get();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
        );
    }
}
