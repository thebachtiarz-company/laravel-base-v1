<?php

namespace TheBachtiarz\Base\Config\Http\Controllers;

use Illuminate\Http\JsonResponse;
use TheBachtiarz\Base\App\Controllers\AbstractController;
use TheBachtiarz\Base\Config\Services\ConfigService;

class ConfigController extends AbstractController
{
    //

    /**
     * Constructor
     *
     * @param ConfigService $configService
     */
    public function __construct(
        protected ConfigService $configService
    ) {
        parent::__construct();
        $this->configService = $configService;
    }

    public function create(): JsonResponse
    {
        // $this->configService->createOrUpdate('alpha.beta.charlie', 'GYGyuYUFyufytfygeguih56734gffsdvf3ygfs7dfdf67ds67d7Fft67dfggj');
        $this->configService->getConfigValue('thebachtiarz_base.app_key');

        return static::$responseHelper::getJsonResult();
    }
}
