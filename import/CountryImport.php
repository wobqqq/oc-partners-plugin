<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Import;

use App;
use Backend\Models\ImportModel;
use Blackseadigital\Partners\Exceptions\ImportException;
use Blackseadigital\Partners\Models\Country;
use BlackSeaDigital\Partners\Services\CountryService;
use BlackSeaDigital\Partners\Transformers\ImportTransformer;
use October\Rain\Database\Traits\Validation;

final class CountryImport extends ImportModel
{
    use Validation;

    private readonly CountryService $countryService;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->countryService = App::make(CountryService::class);
    }

    public array $rules = [
        'name' => 'required',
        'external_id' => 'required',
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
        $countryRowDto = ImportTransformer::countryFromRow($row);
        $countryModelDto = ImportTransformer::countryFromRowDto($countryRowDto);
        $country = Country::whereExternalId($countryModelDto->externalId)->withTrashed()->first();

        if (empty($country)) {
            $this->countryService->create($countryModelDto);
            $this->logCreated();
        } else {
            $this->countryService->update($countryModelDto, $country);
            $this->logUpdated();
        }
    }
}
