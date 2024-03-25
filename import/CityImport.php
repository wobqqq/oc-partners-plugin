<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Import;

use App;
use Backend\Models\ImportModel;
use Blackseadigital\Partners\Exceptions\ImportException;
use Blackseadigital\Partners\Models\City;
use BlackSeaDigital\Partners\Services\CityService;
use BlackSeaDigital\Partners\Transformers\ImportTransformer;
use October\Rain\Database\Traits\Validation;

final class CityImport extends ImportModel
{
    use Validation;

    private readonly CityService $cityService;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->cityService = App::make(CityService::class);
    }

    public array $rules = [
        'name' => 'required',
        'external_id' => 'required',
        'country_external_id' => 'required',
    ];

    /**
     * @param array $results
     * @param string $sessionKey
     */
    public function importData($results, $sessionKey = null): void
    {
        foreach ($results as $i => $row) {
            try {
                $this->importRow($row);
            } catch (\Exception $e) {
                $this->logError($i, $e->getMessage());
            }
        }
    }

    /**
     * @throws ImportException
     */
    private function importRow(array $row): void
    {
        $cityRowDto = ImportTransformer::cityFromRow($row);
        $cityModelDto = ImportTransformer::cityFromRowDto($cityRowDto);
        $city = City::whereExternalId($cityModelDto->externalId)->withTrashed()->first();

        if (empty($city)) {
            $this->cityService->create($cityModelDto);
            $this->logCreated();
        } else {
            $this->cityService->update($cityModelDto, $city);
            $this->logUpdated();
        }
    }
}
