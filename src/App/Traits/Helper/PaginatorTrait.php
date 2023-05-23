<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Traits\Helper;

use function ceil;
use function count;
use function mb_strlen;
use function usort;

/**
 * Paginator Trait
 */
trait PaginatorTrait
{
    /**
     * Items request sorting
     */
    private static array|null $itemsRequestSort = null;

    // ? Public Methods

    // ? Private Modules

    /**
     * Get paginate result
     *
     * @param array $resultData
     *
     * @return array
     */
    private static function getPaginateResult(
        array $resultData = [],
        int $perPage = 10,
        int $currentPage = 1,
    ): array {
        $_result = [
            'result' => [],
            'page_info' => [
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'total_pages' => 1,
            ],
            'total_count' => count($resultData),
        ];

        /**
         * Sorting process data result
         */
        if (static::$itemsRequestSort) {
            foreach (static::$itemsRequestSort as $attribute => $type) {
                $resultData = static::sortArrayResult($resultData, $attribute, $type);
            }
        }

        $_dataResult = [];

        /**
         * Set total page
         */
        $_result['page_info']['total_pages'] = ceil($_result['total_count'] / $perPage);

        /**
         * Define current page
         */
        for ($_loopCurrentPage = 1; $_loopCurrentPage <= $_result['page_info']['total_pages']; $_loopCurrentPage++) {
            /**
             * Check page section
             */
            if ($_loopCurrentPage !== $currentPage) {
                continue;
            }

            /**
             * Define start - finish item index
             */
            $_indexStart  = ($currentPage - 1) * $perPage;
            $_indexFinish = $_result['total_count'] < $currentPage * $perPage
                ? $_result['total_count']
                : $currentPage * $perPage;

            for ($_indexItem = $_indexStart; $_indexItem < $_indexFinish; $_indexItem++) {
                if ($_indexItem + 1 > $_result['total_count']) {
                    break;
                }

                if (count($_dataResult) >= $perPage) {
                    break;
                }

                $_dataResult[] = $resultData[$_indexItem];
            }
        }

        $_result['result'] = $_dataResult;

        return $_result;
    }

    /**
     * Sort array result
     *
     * @param array $data
     *
     * @return array
     */
    private static function sortArrayResult(array $data, string $key = 'name', string $sortType = 'ASC'): array
    {
        usort($data, static function ($a, $b) use ($sortType, $key) {
            if ($sortType === 'ASC') {
                return $a[$key] <=> $b[$key];
            }

            if ($sortType === 'DESC') {
                return $b[$key] <=> $a[$key];
            }
        });

        return $data;
    }

    // ? Setter Modules

    /**
     * Add paginate sort
     *
     * @param string      $attributeName default: ''
     * @param string|null $sortType      default: 'ASC'
     *
     * @return static
     */
    private static function addPaginateSort(string $attributeName = '', string|null $sortType = 'ASC'): static
    {
        if (mb_strlen($attributeName)) {
            static::$itemsRequestSort[$attributeName] = $sortType;
        }

        return new static();
    }
}
