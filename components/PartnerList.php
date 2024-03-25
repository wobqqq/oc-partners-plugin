<?php namespace Blackseadigital\Partners\Components;

use Blackseadigital\Partners\Models\Category;
use Blackseadigital\Partners\Models\City;
use Blackseadigital\Partners\Models\Country;
use Blackseadigital\Partners\Models\Partner;
use Blackseadigital\Partners\Models\Store;
use Blackseadigital\Partners\Queries\CategoryQuery;
use Blackseadigital\Partners\Queries\CityQuery;
use Blackseadigital\Partners\Queries\CountryQuery;
use Blackseadigital\Partners\Queries\PartnerQuery;
use Blackseadigital\Partners\Queries\StoreQuery;
use BlackSeaDigital\Partners\Transformers\FilterTransformer;
use Cms\Classes\ComponentBase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class PartnerList extends ComponentBase
{
    public function __construct(
        private readonly CategoryQuery $categoryQuery,
        private readonly CountryQuery  $countryQuery,
        private readonly CityQuery     $cityQuery,
        private readonly PartnerQuery  $partnerQuery,
        private readonly StoreQuery    $storeQuery,
    )
    {
        parent::__construct();
    }

    public function componentDetails(): array
    {
        return [
            'name' => 'Partner list',
            'description' => ''
        ];
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categoryQuery->getFiltered();
    }

    /**
     * @return Collection<int, Country>
     */
    public function getCountries(): Collection
    {
        return $this->countryQuery->getFiltered();
    }

    /**
     * @return Collection<int, City>
     */
    public function getCities(?array $filter = []): Collection
    {
        $cityFilterDto = FilterTransformer::cityFilterFromRequest($filter);

        return $this->cityQuery->getFiltered($cityFilterDto);
    }

    /**
     * @return LengthAwarePaginator<int, Partner>
     */
    public function getPartners(?array $filter = []): LengthAwarePaginator
    {
        $partnerFilterDto = FilterTransformer::partnerFilterFromRequest($filter);

        return $this->partnerQuery->getFiltered($partnerFilterDto);
    }

    /**
     * @return LengthAwarePaginator<int, Store>
     */

    public function getStores(?array $filter = []): LengthAwarePaginator
    {
        $storeFilterDto = FilterTransformer::storeFilterFromRequest($filter);

        return $this->storeQuery->getFiltered($storeFilterDto);
    }

    public function getStoresMap(?array $filter = []): string
    {
        $storeFilterDto = FilterTransformer::storeFilterFromRequest($filter);
        $stores = $this->storeQuery->getFiltered($storeFilterDto);

        $map = $stores
            ->filter(fn(Store $store) => !empty($store->lat) && !empty($store->lon))
            ->map(fn(Store $store) => [
                'lat' => $store->lat,
                'lon' => $store->lon,
                'title' => $store->address,
                'logo' => $store->partner?->logo?->getPath(),
            ]);

        try {
            return json_encode($map, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            return '';
        }
    }
}
