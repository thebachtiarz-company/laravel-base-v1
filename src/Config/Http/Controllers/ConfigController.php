<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Http\Controllers;

use Illuminate\Http\JsonResponse;
use TheBachtiarz\Base\App\Controllers\AbstractController;
use TheBachtiarz\Base\Config\Services\ConfigService;

class ConfigController extends AbstractController
{
    /**
     * Constructor
     */
    public function __construct(
        protected ConfigService $configService,
    ) {
        parent::__construct();
    }

    /**
     * Create dummy config
     */
    public function create(): JsonResponse
    {
        $this->configService->createOrUpdate('alpha.beta.charlie', 'value to test', '1');

        return $this->getResult();
    }
}
