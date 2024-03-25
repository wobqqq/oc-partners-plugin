<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Transformers;

use Arr;
use BlackSeaDigital\Partners\Dto\Filters\CityFilterDto;
use BlackSeaDigital\Partners\Dto\Filters\PartnerFilterDto;
use BlackSeaDigital\Partners\Dto\Filters\StoreFilterDto;
use Blackseadigital\Partners\Enums\QueryListMode;
use Request;

final class FilterTransformer
{
    public static function cityFilterFromRequest(array $filter): CityFilterDto
    {
        return new CityFilterDto(
            (int)Arr::get($filter, 'countryId'),
        );
    }

    public static function storeFilterFromRequest(array $filter): StoreFilterDto
    {
        return new StoreFilterDto(
            (string)Arr::get($filter, 'mode', QueryListMode::PAGINATION->value),
            (int)Arr::get($filter, 'partnerId'),
            (int)Arr::get($filter, 'cityId'),
            (int)Arr::get($filter, 'countryId'),
            (int)Arr::get($filter, 'categoryId'),
            (string)Arr::get($filter, 'search'),
            (boolean)Arr::get($filter, 'isOnline', false),
            (boolean)Arr::get($filter, 'isOffline', false),
            (int)Arr::get($filter, 'page', 1),
        );
    }

    public static function partnerFilterFromRequest(array $filter): PartnerFilterDto
    {
        return new PartnerFilterDto(
            (int)Arr::get($filter, 'cityId'),
            (int)Arr::get($filter, 'countryId'),
            (int)Arr::get($filter, 'categoryId'),
            (string)Arr::get($filter, 'search'),
            (boolean)Arr::get($filter, 'isOnline', false),
            (boolean)Arr::get($filter, 'isOffline', false),
            (int)Arr::get($filter, 'page', 1),
        );
    }
}
