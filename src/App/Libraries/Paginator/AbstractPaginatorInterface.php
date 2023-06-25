<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Paginator;

interface AbstractPaginatorInterface
{
    public const ATTRIBUTE_RESULT         = 'result';
    public const ATTRIBUTE_PAGEINFO       = 'page_info';
    public const ATTRIBUTE_PERPAGE        = 'per_page';
    public const ATTRIBUTE_CURRENTPAGE    = 'current_page';
    public const ATTRIBUTE_TOTALPAGES     = 'total_pages';
    public const ATTRIBUTE_TOTALCOUNT     = 'total_count';
    public const ATTRIBUTE_SORTATTRIBUTES = 'sort_attributes';

    // ? Public Methods

    /**
     * Get result as array
     *
     * @return array
     */
    public function toArray(): array;

    // ? Getter Modules

    // ? Setter Modules
}
