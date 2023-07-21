<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Http\Controllers;

use Illuminate\Http\JsonResponse;
use TheBachtiarz\Base\App\Http\Controllers\AbstractController;
use TheBachtiarz\Base\Config\Http\Requests\Configs\ConfigCreateRequest;
use TheBachtiarz\Base\Config\Http\Requests\Configs\ConfigPathRequest;
use TheBachtiarz\Base\Config\Http\Requests\Rules\ConfigCreateRule;
use TheBachtiarz\Base\Config\Http\Requests\Rules\ConfigPathRule;
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
     * Create or update config
     */
    public function create(ConfigCreateRequest $request): JsonResponse
    {
        $this->configService->createOrUpdate(
            path: $request->get(key: ConfigPathRule::INPUT_PATH),
            value: $request->get(key: ConfigCreateRule::INPUT_VALUE),
            isEncrypt: $request->get(key: ConfigCreateRule::INPUT_ISENCRYPT, default: false) ? '1' : '2',
        );

        return $this->getResult();
    }

    /**
     * Delete config
     */
    public function delete(ConfigPathRequest $request): JsonResponse
    {
        $this->configService->deleteConfig($request->get(key: ConfigPathRule::INPUT_PATH));

        return $this->getResult();
    }
}
