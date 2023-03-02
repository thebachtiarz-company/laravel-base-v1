<?php

namespace TheBachtiarz\Base\App\Interfaces;

interface CarbonInterface
{
    //

    /**
     * Full human date fomat
     */
    public const CARBON_FULL_HUMAN_DATE_FORMAT = "dddd, D MMMM YYYY, HH:mm:ss";

    /**
     * Human simple format
     */
    public const CARBON_HUMAN_SIMPLE_DATE_FORMAT = "d F Y H:i:s";

    /**
     * Human date format
     */
    public const CARBON_HUMAN_DATE_FORMAT = "d F Y";

    /**
     * Human time format
     */
    public const CARBON_HUMAN_TIME_FORMAT = "H:i:s";

    /**
     * Database simple format
     */
    public const CARBON_DB_SIMPLE_DATE_FORMAT = "Y-m-d H:i:s";

    /**
     * Database date format
     */
    public const CARBON_DB_DATE_FORMAT = "Y-m-d";

    /**
     * Database time format
     */
    public const CARBON_DB_TIME_FORMAT = "H:i:s";
}
