<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REST Routes
|--------------------------------------------------------------------------
|
*/

/**
 * Group    : dadada.
 * URI      : {{base_url}}/{{app_prefix}}/base/dadada/---
 */
Route::prefix('')->middleware('api')->controller()->group(static function (): void {
    /**
     * Name     : Bla bla bla.
     * Method   : POST.
     * URL      : {{base_url}}/{{app_prefix}}/base/dadada/dididi
     */
    Route::post('dididi', 'methodName');
});
