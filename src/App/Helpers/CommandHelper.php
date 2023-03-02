<?php

namespace TheBachtiarz\Base\App\Helpers;

use Illuminate\Support\Facades\Artisan;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;

class CommandHelper
{
    //

    /**
     * Constructor
     *
     * @param LogLibrary $logLibrary
     */
    public function __construct(
        protected LogLibrary $logLibrary
    ) {
        $this->logLibrary = $logLibrary;
    }

    // ? Public Methods
    /**
     * Run command php artisan
     *
     * @param string $command
     * @param string|null $message
     * @return void
     */
    public function phpArtisan(string $command, ?string $message = null): void
    {
        Artisan::call($command);

        if ($message) $this->logLibrary->log($message);
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
