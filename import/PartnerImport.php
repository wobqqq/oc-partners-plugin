<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Import;

use App;
use Backend\Models\ImportModel;
use Blackseadigital\Partners\Exceptions\ImportException;
use Blackseadigital\Partners\Models\Partner;
use BlackSeaDigital\Partners\Services\PartnerService;
use BlackSeaDigital\Partners\Transformers\ImportTransformer;
use October\Rain\Database\Traits\Validation;

final class PartnerImport extends ImportModel
{
    use Validation;

    private readonly PartnerService $partnerService;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->partnerService = App::make(PartnerService::class);
    }

    public array $rules = [
        'external_id' => 'required',
        'name' => 'required',
        'category_external_id' => 'required',
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
        $partnerRowDto = ImportTransformer::partnerFromRow($row);
        $partnerModelDto = ImportTransformer::partnerFromRowDto($partnerRowDto);
        $partner = Partner::whereExternalId($partnerModelDto->externalId)->withTrashed()->first();

        if (empty($partner)) {
            $this->partnerService->create($partnerModelDto);
            $this->logCreated();
        } else {
            $this->partnerService->update($partnerModelDto, $partner);
            $this->logUpdated();
        }
    }
}
