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
     * Response Helper
     *
     * @var ResponseHelper
     */
    protected static $responseHelper = ResponseHelper::class;

    /**
     * Constructor
     */
    public function __construct()
    {
        static::$responseHelper::setAccessStart();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        static::$responseHelper::setAccessFinish();
    }

    /**
     * Get response result
     */
    protected function getResult(): JsonResponse
    {
        return static::$responseHelper::getJsonResult();
    }
}
