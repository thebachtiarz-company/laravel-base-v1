<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Helpers;

use Illuminate\Support\Facades\Artisan;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;

class CommandHelper
{
    /**
     * Constructor
     */
    public function __construct(
        protected LogLibrary $logLibrary,
    ) {
        $this->logLibrary = $logLibrary;
    }

    // ? Public Methods

    /**
     * Run command php artisan
     */
    public function phpArtisan(string $command, string|null $message = null): void
    {
        Artisan::call($command);

        if (! $message) {
            return;
        }

        $this->logLibrary->log($message);
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
