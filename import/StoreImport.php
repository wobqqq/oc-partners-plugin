<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Import;

use App;
use Backend\Models\ImportModel;
use Blackseadigital\Partners\Exceptions\ImportException;
use Blackseadigital\Partners\Models\Store;
use BlackSeaDigital\Partners\Services\StoreService;
use BlackSeaDigital\Partners\Transformers\ImportTransformer;
use Cache;
use October\Rain\Database\Traits\Validation;

final class StoreImport extends ImportModel
{
    use Validation;

    private readonly StoreService $storeService;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->storeService = App::make(StoreService::class);
    }

    public array $rules = [
        'external_id' => 'required',
        'address' => 'required',
        'partner_external_id' => 'required',
        'city_external_id' => 'required',
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

        Cache::clear();
    }

    /**
     * @throws ImportException
     */
    private function importRow(array $row): void
    {
        $storeRowDto = ImportTransformer::storeFromRow($row);
        $storeModelDto = ImportTransformer::storeFromRowDto($storeRowDto);
        $store = Store::whereExternalId($storeModelDto->externalId)->withTrashed()->first();

        if (empty($store)) {
            $this->storeService->create($storeModelDto);
            $this->logCreated();
        } else {
            $this->storeService->update($storeModelDto, $store);
            $this->logUpdated();
        }
    }
}
