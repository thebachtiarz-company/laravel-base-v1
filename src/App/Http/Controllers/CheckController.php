<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class CheckController extends AbstractController
{
    // ? Public Methods

    /**
     * Get check
     */
    public function getCheck(): JsonResponse
    {
        $this->response()::setResponseData(message: 'OK')
            ->setStatus('success')
            ->setHttpCode(200);

        return $this->getResult();
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
