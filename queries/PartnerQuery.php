<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Queries;

use BlackSeaDigital\Partners\Dto\Filters\PartnerFilterDto;
use Blackseadigital\Partners\Models\City;
use Blackseadigital\Partners\Models\Partner;
use Blackseadigital\Partners\Models\Store;
use October\Rain\Database\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class PartnerQuery
{
    private Builder|Partner $partner;

    public function __construct()
    {
        $this->partner = Partner::query();
    }

    /**
     * @return LengthAwarePaginator<int, Partner>
     */
    public function getFiltered(PartnerFilterDto $partnerFilterDto): LengthAwarePaginator
    {
        return $this->partner
            ->whereIsActive(true)
            ->when(
                !empty($partnerFilterDto->categoryId),
                fn(Builder|Partner $q) => $q->whereCategoryId($partnerFilterDto->categoryId),
            )
            ->when($partnerFilterDto->isOnline, fn(Builder|Partner $q) => $q->whereIsOnline(true))
            ->when($partnerFilterDto->isOffline, fn(Builder|Partner $q) => $q->whereIsOffline(true))
            ->when(!empty($partnerFilterDto->search), fn(Builder|Partner $q) => $q
                ->searchWhere($partnerFilterDto->search, ['name'])
                ->orSearchWhereRelation($partnerFilterDto->search, 'stores', ['address'])
            )
            ->when(
                (!empty($partnerFilterDto->countryId) || !empty($partnerFilterDto->cityId)),
                fn(Builder|Store $q) => $q
                ->when(
                    !empty($partnerFilterDto->cityId),
                    fn(Builder|Store $q) => $q->whereCityId($partnerFilterDto->cityId),
                )
                ->when(!empty($partnerFilterDto->countryId), fn(Builder|Store $q) => $q
                    ->whereHas('city', fn(Builder|City $q) => $q->whereId($partnerFilterDto->countryId))
                )
            )
            ->with(['logo'])
            ->paginate($partnerFilterDto->perPage, ['*'], 'page', $partnerFilterDto->page);
    }
}
