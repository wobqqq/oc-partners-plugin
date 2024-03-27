<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Transformers;

use Arr;
use BlackSeaDigital\Partners\Dto\Filters\CityFilterDto;
use BlackSeaDigital\Partners\Dto\Filters\CountryFilterDto;
use BlackSeaDigital\Partners\Dto\Filters\PartnerFilterDto;
use BlackSeaDigital\Partners\Dto\Filters\StoreFilterDto;

final class FilterTransformer
{
    public static function cityFilterFromRequest(array $filter): CityFilterDto
    {
        return new CityFilterDto(
            (array)Arr::get($filter, 'countryIds', []),
            (int)Arr::get($filter, 'partnerId'),
        );
    }

    public static function countryFilterFromRequest(array $filter): CountryFilterDto
    {
        return new CountryFilterDto(
            (int)Arr::get($filter, 'partnerId'),
        );
    }

    public static function storeFilterFromRequest(array $filter, int $perPage): StoreFilterDto
    {
        return new StoreFilterDto(
            (int)Arr::get($filter, 'partnerId'),
            (array)Arr::get($filter, 'cityIds', []),
            (array)Arr::get($filter, 'countryIds', []),
            (array)Arr::get($filter, 'categoryIds', []),
            (string)Arr::get($filter, 'search'),
            (boolean)Arr::get($filter, 'isOnline', false),
            (boolean)Arr::get($filter, 'isOffline', false),
            (int)Arr::get($filter, 'page', 1),
            $perPage,
        );
    }

    public static function partnerFilterFromRequest(array $filter): PartnerFilterDto
    {
        return new PartnerFilterDto(
            (array)Arr::get($filter, 'cityIds', []),
            (array)Arr::get($filter, 'countryIds', []),
            (array)Arr::get($filter, 'categoryIds', []),
            (string)Arr::get($filter, 'search'),
            (boolean)Arr::get($filter, 'isOnline', false),
            (boolean)Arr::get($filter, 'isOffline', false),
            (int)Arr::get($filter, 'page', 1),
        );
    }
}
