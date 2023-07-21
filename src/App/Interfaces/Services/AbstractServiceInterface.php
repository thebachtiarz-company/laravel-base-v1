<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Interfaces\Services;

interface AbstractServiceInterface
{
    // ? Getter Modules

    // ? Setter Modules

    /**
     * Hide response result
     *
     * @return static
     */
    public function hideResponseResult(): static;

    /**
     * Ignore any log
     *
     * @return static
     */
    public function ignoreLog(): static;
}
