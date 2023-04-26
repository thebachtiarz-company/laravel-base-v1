<?php

namespace TheBachtiarz\Base\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use TheBachtiarz\Base\App\Helpers\ResponseHelper;

class PaginateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->has('perPage')
            || $request->has('currentPage')
            || $request->has('sortAttribute')
            || $request->has('sortType')
        ) {
            ResponseHelper::asPaginate(
                perPage: $request->get('perPage') ?? 15,
                currentPage: $request->get('currentPage') ?? 1,
                sortAttribute: $request->get('sortAttribute') ?? null,
                sortType: $request->get('sortType') ?? null
            );
        }

        return $next($request);
    }
}
