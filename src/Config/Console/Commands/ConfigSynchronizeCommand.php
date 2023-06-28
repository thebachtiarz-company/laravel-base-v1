<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Console\Commands;

use TheBachtiarz\Base\App\Console\Commands\AbstractCommand;
use TheBachtiarz\Base\App\Helpers\CommandHelper;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;
use TheBachtiarz\Base\Config\Services\ConfigService;

use function sprintf;

class ConfigSynchronizeCommand extends AbstractCommand
{
    /**
     * {@inheritDoc}
     *
     * @param ConfigService $configService
     * @param CommandHelper $commandHelper
     * @param LogLibrary    $logLibrary
     */
    public function __construct(
        protected ConfigService $configService,
        protected CommandHelper $commandHelper,
        protected LogLibrary $logLibrary,
    ) {
        $this->signature    = 'thebachtiarz:base:config:sync';
        $this->commandTitle = 'Apps config synchronize';
        $this->description  = 'Synchronize All Config Into Database';

        parent::__construct();
    }

    public function commandProcess(): bool
    {
        $this->logLibrary->log(sprintf('======> %s, starting...', $this->commandTitle));

        $syncProcess = $this->configService->synchronizeConfig();

        $this->logLibrary->log(sprintf('======> %s, finish', $this->commandTitle));

        return $syncProcess;
    }
}
