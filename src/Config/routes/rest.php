<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use TheBachtiarz\Base\Config\Http\Controllers\ConfigController;

/*
|--------------------------------------------------------------------------
| REST Routes
|--------------------------------------------------------------------------
|
*/

/**
 * Group    : Config.
 * URI      : {{base_url}}/{{app_prefix}}/base/config/---
 */
Route::prefix('config')->middleware('api')->controller(ConfigController::class)->group(static function (): void {
    /**
     * Name     : Create or update config.
     * Method   : POST.
     * URL      : {{base_url}}/{{app_prefix}}/base/config/create
     */
    Route::post('create', 'create');

    /**
     * Name     : Delete config.
     * Method   : POST.
     * URL      : {{base_url}}/{{app_prefix}}/base/config/delete
     */
    Route::post('delete', 'delete');
});
