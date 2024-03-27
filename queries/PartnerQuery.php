<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Queries;

use BlackSeaDigital\Partners\Dto\Filters\PartnerFilterDto;
use Blackseadigital\Partners\Models\Partner;
use Blackseadigital\Partners\Models\Store;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use October\Rain\Database\Builder;

final readonly class PartnerQuery
{
    public function getFiltered(PartnerFilterDto $partnerFilterDto): LengthAwarePaginator
    {
        return Partner::whereIsActive(true)
            ->when(
                !empty($partnerFilterDto->categoryIds),
                fn(Builder|Partner $q) => $q->whereIn('category_id', $partnerFilterDto->categoryIds),
            )
            ->when(!empty($partnerFilterDto->isOnline), fn(Builder|Partner $q) => $q->whereIsOnline(true))
            ->when(!empty($partnerFilterDto->isOffline), fn(Builder|Partner $q) => $q->whereIsOffline(true))
            ->when(!empty($partnerFilterDto->search), fn(Builder|Partner $q) => $q
                ->searchWhere($partnerFilterDto->search, ['name'])
                ->orSearchWhereRelation($partnerFilterDto->search, 'stores', ['address'])
            )
            ->when(
                (!empty($partnerFilterDto->countryIds) || !empty($partnerFilterDto->cityIds)),
                fn(Builder|Store $q) => $q->whereHas(
                    'stores',
                    fn(Builder|Store $q) => $q
                        ->when(
                            !empty($partnerFilterDto->cityIds),
                            fn(Builder|Store $q) => $q->whereIn('city_id', $partnerFilterDto->cityIds),
                        )
                        ->when(
                            !empty($partnerFilterDto->countryIds),
                            fn(Builder|Store $q) => $q->whereIn('country_id', $partnerFilterDto->countryIds),
                        )
                )
            )
            ->with(['logo'])
            ->paginate($partnerFilterDto->perPage, ['*'], 'page', $partnerFilterDto->page);
    }
}
