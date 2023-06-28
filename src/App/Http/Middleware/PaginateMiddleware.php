<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use TheBachtiarz\Base\App\Helpers\ResponseHelper;
use TheBachtiarz\Base\App\Http\Requests\Rule\PaginateRule;
use TheBachtiarz\Base\App\Libraries\Paginator\Params\PaginatorParam;
use Throwable;

use function intval;
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
        $validate = Validator::make(
            data: $request->all(),
            rules: PaginateRule::rules(),
            messages: PaginateRule::messages(),
        );

        if ($validate->fails()) {
            throw new ValidationException($validate);
        }

        try {
            if ($request->has(key: PaginateRule::INPUT_PERPAGE)) {
                ResponseHelper::asPaginate(
                    perPage: intval(value: $request->get(
                        key: PaginateRule::INPUT_PERPAGE,
                        default: PaginatorParam::getPerPage(),
                    )),
                );
            }

            if ($request->has(key: PaginateRule::INPUT_CURRENTPAGE)) {
                ResponseHelper::asPaginate(
                    currentPage: intval(value: $request->get(
                        key: PaginateRule::INPUT_CURRENTPAGE,
                        default: PaginatorParam::getCurrentPage(),
                    )),
                );
            }

            if ($request->has(key: PaginateRule::INPUT_SORTOPTIONS)) {
                ResponseHelper::asPaginate(
                    sortOptions: json_decode(json: $request->get(
                        key: PaginateRule::INPUT_SORTOPTIONS,
                        default: '[]',
                    ), associative: true),
                );
            }

            if ($request->has(key: PaginateRule::INPUT_ATTRIBUTESPAGINATEOPTIONS)) {
                ResponseHelper::asPaginate(
                    attributesPaginateOptions: json_decode(json: $request->get(
                        key: PaginateRule::INPUT_ATTRIBUTESPAGINATEOPTIONS,
                        default: '[]',
                    ), associative: true),
                );
            }
        } catch (Throwable) {
            throw new ValidationException($validate);
        }

        return $next($request);
    }
}
