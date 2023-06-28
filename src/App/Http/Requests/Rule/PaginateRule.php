<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Http\Requests\Rule;

use function sprintf;

class PaginateRule extends AbstractRule
{
    public const INPUT_PERPAGE                   = 'perPage';
    public const INPUT_CURRENTPAGE               = 'currentPage';
    public const INPUT_SORTOPTIONS               = 'sortOptions';
    public const INPUT_ATTRIBUTESPAGINATEOPTIONS = 'attributesPaginateOptions';

    public static function rules(): array
    {
        return [
            self::INPUT_PERPAGE => [
                'nullable',
                'numeric',
            ],
            self::INPUT_CURRENTPAGE => [
                'nullable',
                'numeric',
            ],
            self::INPUT_SORTOPTIONS => [
                'nullable',
                'json',
            ],
            self::INPUT_ATTRIBUTESPAGINATEOPTIONS => [
                'nullable',
                'json',
            ],
        ];
    }

    public static function messages(): array
    {
        return [
            sprintf('%s.numeric', self::INPUT_PERPAGE) => 'Input per page sould be a number',
            sprintf('%s.numeric', self::INPUT_CURRENTPAGE) => 'Input current page sould be a number',
            sprintf('%s.json', self::INPUT_SORTOPTIONS) => 'Input sort options should be JSON format',
            sprintf('%s.json', self::INPUT_ATTRIBUTESPAGINATEOPTIONS) => 'Input attribute paginate options should be JSON format',
        ];
    }
}
