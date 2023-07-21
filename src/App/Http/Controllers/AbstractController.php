<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use TheBachtiarz\Base\App\Helpers\ResponseHelper;
use TheBachtiarz\Base\App\Interfaces\Http\Controllers\AbstractControllerInterface;

abstract class AbstractController extends Controller implements AbstractControllerInterface
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->response()::init();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->response()::end();
    }

    // ? Public Methods

    // ? Protected Methods

    /**
     * Call response helper
     */
    protected function response(): ResponseHelper
    {
        return new ResponseHelper();
    }

    /**
     * Get response result
     */
    protected function getResult(): JsonResponse
    {
        return $this->response()::getJsonResult();
    }

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
