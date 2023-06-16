<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use TheBachtiarz\Base\App\Helpers\ResponseHelper;

use function json_decode;

class PaginateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->has(key: 'perPage')
            || $request->has(key: 'currentPage')
            || $request->has(key: 'sortAttribute')
            || $request->has(key: 'sortType')
        ) {
            ResponseHelper::asPaginate(
                perPage: (int) $request->get(key: 'perPage', default: 15),
                currentPage: (int) $request->get(key: 'currentPage', default: 1),
                sortAttribute: $request->get(key: 'sortAttribute', default: null),
                sortType: $request->get(key: 'sortType', default: null),
            );
        }

        if ($request->has(key: 'paginateAttribute')) {
            ResponseHelper::attributesPaginate(
                paginateOptions: json_decode(
                    json: $request->get(key: 'paginateAttribute'),
                    associative: true,
                ),
            );
        }

        return $next($request);
    }
}
