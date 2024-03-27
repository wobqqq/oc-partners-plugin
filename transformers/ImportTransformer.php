<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Transformers;

use App;
use Arr;
use BlackSeaDigital\Partners\Dto\Models\CategoryModelDto;
use BlackSeaDigital\Partners\Dto\Models\CityModelDto;
use BlackSeaDigital\Partners\Dto\Models\CountryModelDto;
use BlackSeaDigital\Partners\Dto\Models\StoreModelDto;
use BlackSeaDigital\Partners\Dto\Rows\CategoryRowDto;
use BlackSeaDigital\Partners\Dto\Rows\CityRowDto;
use BlackSeaDigital\Partners\Dto\Rows\CountryRowDto;
use BlackSeaDigital\Partners\Dto\Models\PartnerModelDto;
use BlackSeaDigital\Partners\Dto\Rows\PartnerRowDto;
use BlackSeaDigital\Partners\Dto\Rows\StoreRowDto;
use Blackseadigital\Partners\Exceptions\ImportException;
use Blackseadigital\Partners\Models\Category;
use Blackseadigital\Partners\Models\City;
use Blackseadigital\Partners\Models\Country;
use Blackseadigital\Partners\Models\Partner;
use Str;

final class ImportTransformer
{
    /**
     * @throws ImportException
     */
    public static function categoryFromRow(array $row): CategoryRowDto
    {
        $categoryRowDto = new CategoryRowDto(
            (string)Arr::get($row, 'name'),
            (string)Arr::get($row, 'external_id'),
        );

        if (empty($categoryRowDto->externalId)) {
            throw new ImportException('Category external id not found');
        }

        return $categoryRowDto;
    }

    /**
     * @throws ImportException
     */
    public static function countryFromRow(array $row): CountryRowDto
    {
        $countryRowDto = new CountryRowDto(
            (string)Arr::get($row, 'name'),
            (string)Arr::get($row, 'external_id'),
        );

        if (empty($countryRowDto->externalId)) {
            throw new ImportException('Country external id not found');
        }

        return $countryRowDto;
    }

    /**
     * @throws ImportException
     */
    public static function cityFromRow(array $row): CityRowDto
    {
        $cityRowDto = new CityRowDto(
            (string)Arr::get($row, 'name'),
            (string)Arr::get($row, 'external_id'),
            (string)Arr::get($row, 'country_external_id'),
        );

        if (empty($cityRowDto->externalId)) {
            throw new ImportException('City external id not found');
        }

        return $cityRowDto;
    }

    /**
     * @throws ImportException
     */
    public static function partnerFromRow(array $row): PartnerRowDto
    {
        $partnerRowDto = new PartnerRowDto(
            (string)Arr::get($row, 'name'),
            (string)Arr::get($row, 'external_id'),
            (string)Arr::get($row, 'category_external_id'),
            (bool)Arr::get($row, 'is_active', false),
            (bool)Arr::get($row, 'is_online', false),
            (bool)Arr::get($row, 'is_offline', false),
            (string)Arr::get($row, 'online_points'),
            (string)Arr::get($row, 'offline_points'),
            (string)Arr::get($row, 'interest_free_installments'),
            (string)Arr::get($row, 'link'),
            (string)Arr::get($row, 'description'),
            (string)Arr::get($row, 'logo'),
            explode(',', (string)Arr::get($row, 'banners'))
        );

        if (empty($partnerRowDto->externalId)) {
            throw new ImportException('Partner external id not found');
        }

        return $partnerRowDto;
    }

    /**
     * @throws ImportException
     */
    public static function storeFromRow(array $row): StoreRowDto
    {
        $storeRowDto = new StoreRowDto(
            (string)Arr::get($row, 'external_id'),
            (string)Arr::get($row, 'address'),
            (string)Arr::get($row, 'lat'),
            (string)Arr::get($row, 'lon'),
            (string)Arr::get($row, 'partner_external_id'),
            (string)Arr::get($row, 'city_external_id'),
        );

        if (empty($storeRowDto->externalId)) {
            throw new ImportException('Store external id not found');
        }

        return $storeRowDto;
    }

    public static function categoryFromRowDto(CategoryRowDto $categoryRowDto): CategoryModelDto
    {
        return new CategoryModelDto(
            trim($categoryRowDto->name),
            Str::slug($categoryRowDto->externalId),
        );
    }

    public static function countryFromRowDto(CountryRowDto $countryRowDto): CountryModelDto
    {
        return new CountryModelDto(
            trim($countryRowDto->name),
            Str::slug($countryRowDto->externalId),
        );
    }

    /**
     * @throws ImportException
     */
    public static function cityFromRowDto(CityRowDto $cityRowDto): CityModelDto
    {
        $country = Country::whereExternalId($cityRowDto->countryExternalId)->withTrashed()->first();

        if (empty($country)) {
            throw new ImportException('Country not found');
        }

        return new CityModelDto(
            trim($cityRowDto->name),
            $country->id,
            Str::slug($cityRowDto->externalId),
        );
    }

    /**
     * @throws ImportException
     */
    public static function partnerFromRowDto(PartnerRowDto $partnerRowDto): PartnerModelDto
    {
        $category = Category::whereExternalId($partnerRowDto->categoryExternalId)->withTrashed()->first();

        if (empty($category)) {
            throw new ImportException('Category not found');
        }

        $logo = !empty($partnerRowDto->logo)
            ? App::storagePath(sprintf('app/media/%s', trim($partnerRowDto->logo)))
            : null;

        $banners = array_filter($partnerRowDto->banners);
        $banners = array_map(fn(string $banner) => App::storagePath(sprintf(
            'app/media/%s',
            trim($banner),
        )), $banners);

        return new PartnerModelDto(
            trim($partnerRowDto->name),
            $category->id,
            $partnerRowDto->isActive,
            $partnerRowDto->isOnline,
            $partnerRowDto->isOffline,
            trim($partnerRowDto->onlinePoints),
            trim($partnerRowDto->offlinePoints),
            trim($partnerRowDto->interestFreeInstallments),
            trim($partnerRowDto->link),
            trim($partnerRowDto->description),
            Str::slug($partnerRowDto->externalId),
            $logo,
            $banners,
        );
    }

    /**
     * @throws ImportException
     */
    public static function storeFromRowDto(StoreRowDto $storeRowDto): StoreModelDto
    {
        $partner = Partner::whereExternalId($storeRowDto->partnerExternalId)->withTrashed()->first();

        if (empty($partner)) {
            throw new ImportException('Partner not found');
        }

        $city = City::whereExternalId($storeRowDto->cityExternalId)->withTrashed()->first();

        if (empty($city)) {
            throw new ImportException('City not found');
        }

        return new StoreModelDto(
            trim($storeRowDto->address),
            $partner->id,
            $city->id,
            $city->country_id,
            Str::slug($storeRowDto->externalId),
            trim($storeRowDto->lat),
            trim($storeRowDto->lon),
        );
    }
}
