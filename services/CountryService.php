<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Services;

use BlackSeaDigital\Partners\Dto\Models\CountryModelDto;
use Blackseadigital\Partners\Models\Country;

final class CountryService
{
    public function create(CountryModelDto $countryModelDto): Country
    {
        return Country::create([
            'name' => $countryModelDto->name,
            'external_id' => $countryModelDto->externalId,
            'deleted_at' => $countryModelDto->deletedAt,
        ]);
    }

    public function update(CountryModelDto $countryModelDto, Country $country): Country
    {
        $country->update([
            'name' => $countryModelDto->name,
            'external_id' => $countryModelDto->externalId,
            'deleted_at' => $countryModelDto->deletedAt,
        ]);

        return $country;
    }
}
