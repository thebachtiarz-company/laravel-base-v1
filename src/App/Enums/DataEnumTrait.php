<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Enums;

use function array_column;

/**
 * Data Enum Trait
 */
trait DataEnumTrait
{
    /**
     * Get column value
     */
    public static function values(): array
    {
        return array_column(
            array: self::cases(),
            column_key: 'value',
        );
    }
}
