<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use TheBachtiarz\Base\App\Helpers\ResponseHelper;

abstract class AbstractController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Constructor
     */
    public function __construct()
    {
        ResponseHelper::init();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
    }

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
}
