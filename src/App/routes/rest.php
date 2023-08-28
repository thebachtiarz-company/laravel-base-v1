<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use TheBachtiarz\Base\App\Http\Controllers\CheckController;

/*
|--------------------------------------------------------------------------
| REST Routes
|--------------------------------------------------------------------------
|
*/

/**
 * Group    : base.
 * URI      : {{base_url}}/{{app_prefix}}/base/---
 */
Route::prefix('base')->middleware('api')->controller(CheckController::class)->group(static function (): void {
    /**
     * Name     : Check.
     * Method   : GET.
     * URL      : {{base_url}}/{{app_prefix}}/base/checks
     */
    Route::get('checks', 'getCheck');
});
