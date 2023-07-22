<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Traits\Helpers;

use function ceil;
use function count;
use function mb_strlen;
use function sprintf;
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
        PROCESS_BEGIN:
        $result = [
            'result' => [],
            'page_info' => [
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'total_pages' => 1,
            ],
            'total_count' => count($resultData),
            'sort_attributes' => [],
        ];

        /**
         * Sorting process data before paginate process
         */
        PROCESS_SORTING_DATA:
        if (static::$itemsRequestSort) {
            foreach (static::$itemsRequestSort as $attribute => $type) {
                $resultData                  = static::sortArrayResult($resultData, $attribute, $type);
                $result['sort_attributes'][] = sprintf('%s_%s', $attribute, $type);
            }
        }

        $dataResult = [];

        /**
         * Set total page
         */
        PROCESS_SET_TOTAL_PAGE:
        $result['page_info']['total_pages'] = ceil($result['total_count'] / $perPage);

        /**
         * Define current page
         */
        PROCESS_SET_CURRENT_PAGE_DATA:
        for ($loopCurrentPage = 1; $loopCurrentPage <= $result['page_info']['total_pages']; $loopCurrentPage++) {
            /**
             * Check page section
             */
            if ($loopCurrentPage !== $currentPage) {
                continue;
            }

            /**
             * Define start - finish item index
             */
            $indexStart  = ($currentPage - 1) * $perPage;
            $indexFinish = $result['total_count'] < $currentPage * $perPage
                ? $result['total_count']
                : $currentPage * $perPage;

            for ($indexItem = $indexStart; $indexItem < $indexFinish; $indexItem++) {
                if ($indexItem + 1 > $result['total_count']) {
                    break;
                }

                if (count($dataResult) >= $perPage) {
                    break;
                }

                $dataResult[] = $resultData[$indexItem];
            }
        }

        /**
         * Check if current page is not correct
         */
        PROCESS_CURRENT_PAGE_REDUCER:
        if (count($dataResult) < 1 && $currentPage > 1) {
            $currentPage                         = $result['page_info']['total_pages'];
            $result['page_info']['current_page'] = $currentPage;
            goto PROCESS_SET_CURRENT_PAGE_DATA;
        }

        $result['result'] = $dataResult;

        return $result;
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
