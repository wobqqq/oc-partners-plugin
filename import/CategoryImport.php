<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Import;

use App;
use Backend\Models\ImportModel;
use Blackseadigital\Partners\Exceptions\ImportException;
use Blackseadigital\Partners\Models\Category;
use BlackSeaDigital\Partners\Services\CategoryService;
use BlackSeaDigital\Partners\Transformers\ImportTransformer;
use October\Rain\Database\Traits\Validation;

final class CategoryImport extends ImportModel
{
    use Validation;

    private readonly CategoryService $categoryService;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->categoryService = App::make(CategoryService::class);
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
        $categoryRowDto = ImportTransformer::categoryFromRow($row);
        $categoryModelDto = ImportTransformer::categoryFromRowDto($categoryRowDto);
        $category = Category::whereExternalId($categoryModelDto->externalId)->withTrashed()->first();

        if (empty($category)) {
            $this->categoryService->create($categoryModelDto);
            $this->logCreated();
        } else {
            $this->categoryService->update($categoryModelDto, $category);
            $this->logUpdated();
        }
    }
}
