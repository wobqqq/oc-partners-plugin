<?php

use Blackseadigital\Partners\Http\Controllers\StoreController;

Route::prefix('api')->group(function () {
    Route::get('stores/map.json', [StoreController::class, 'getMap']);
});
