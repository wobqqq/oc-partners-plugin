<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Http\Controllers;

use Blackseadigital\Partners\Cache\StoreCache;
use Blackseadigital\Partners\Queries\StoreQuery;
use BlackSeaDigital\Partners\Transformers\FilterTransformer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Controller;

final class StoreController extends Controller
{
    public function getMap(FormRequest $request, StoreCache $storeCache): string
    {
        $storeFilterDto = FilterTransformer::storeFilterFromRequest($request->all(), StoreQuery::MAP_PER_PAGE);

        return $storeCache->getFilteredMap($storeFilterDto);
    }
}
