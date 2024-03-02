<?php

namespace TheBachtiarz\Base\App\Enums;

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
