<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Console\Commands;

use Illuminate\Console\Command;
use TheBachtiarz\Base\App\Helpers\CommandHelper;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;
use TheBachtiarz\Base\Config\Services\ConfigService;

use function sprintf;

class ConfigSynchronizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected string $signature = 'thebachtiarz:base:config:sync';

    /**
     * The console command description.
     */
    protected string $description = 'Synchronize All Config Into Database';

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
        parent::__construct();

        $this->configService = $configService;
        $this->commandHelper = $commandHelper;
        $this->logLibrary    = $logLibrary;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->logLibrary->log('======> Apps config synchronize, starting...');
        $this->info('======> Apps config synchronize, starting...');

        /**
         * Execute synchronize config process
         */
        $syncProcess    = $this->configService->synchronizeConfig();
        $messageProcess = sprintf('======> %s synchronize config', $syncProcess ? 'Successfully' : 'Failed to');
        $this->logLibrary->log($messageProcess);
        $this->{$syncProcess ? 'info' : 'error'}($messageProcess);

        $this->logLibrary->log('======> Synchorizing apps config finish');
        $this->info('======> Synchorizing apps config finish');

        return $syncProcess ? Command::SUCCESS : Command::FAILURE;
    }
}
