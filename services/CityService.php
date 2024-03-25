<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Services;

use BlackSeaDigital\Partners\Dto\Models\CityModelDto;
use Blackseadigital\Partners\Models\City;

final class CityService
{
    public function create(CityModelDto $cityModelDto): City
    {
        return City::create([
            'name' => $cityModelDto->name,
            'country_id' => $cityModelDto->countryId,
            'external_id' => $cityModelDto->externalId,
            'deleted_at' => $cityModelDto->deletedAt,
        ]);
    }

    public function update(CityModelDto $cityModelDto, City $city): City
    {
        $city->update([
            'name' => $cityModelDto->name,
            'country_id' => $cityModelDto->countryId,
            'external_id' => $cityModelDto->externalId,
            'deleted_at' => $cityModelDto->deletedAt,
        ]);

        return $city;
    }
}
