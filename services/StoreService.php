<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Services;

use BlackSeaDigital\Partners\Dto\Models\StoreModelDto;
use Blackseadigital\Partners\Models\Store;

final class StoreService
{
    public function create(StoreModelDto $storeModelDto): Store
    {
        return Store::create([
            'external_id' => $storeModelDto->externalId,
            'address' => $storeModelDto->address,
            'lat' => $storeModelDto->lat,
            'lon' => $storeModelDto->lon,
            'city_id' => $storeModelDto->cityId,
            'country_id' => $storeModelDto->countryId,
            'partner_id' => $storeModelDto->partnerId,
            'deleted_at' => $storeModelDto->deletedAt,
        ]);
    }

    public function update(StoreModelDto $storeModelDto, Store $store): Store
    {
        $store->update([
            'external_id' => $storeModelDto->externalId,
            'address' => $storeModelDto->address,
            'lat' => $storeModelDto->lat,
            'lon' => $storeModelDto->lon,
            'city_id' => $storeModelDto->cityId,
            'country_id' => $storeModelDto->countryId,
            'partner_id' => $storeModelDto->partnerId,
            'deleted_at' => $storeModelDto->deletedAt,
        ]);

        return $store;
    }
}
