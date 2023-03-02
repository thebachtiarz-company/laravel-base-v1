<?php

namespace TheBachtiarz\Base\Config\Console\Commands;

use Illuminate\Console\Command;
use TheBachtiarz\Base\Config\Services\ConfigService;

class ConfigSynchronizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thebachtiarz:base:config:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize All Config Into Database';

    /**
     * {@inheritDoc}
     *
     * @param ConfigService $configService
     */
    public function __construct(
        protected ConfigService $configService
    ) {
        parent::__construct();
        $this->configService = $configService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('------> Config Sync Starting');

        $_syncProcess = $this->configService->synchronizeConfig();

        $_messageProcess = sprintf('------> %s synchronize config', $_syncProcess ? 'Successfully' : 'Failed to');

        $this->{$_syncProcess ? 'info' : 'error'}($_messageProcess);

        $this->info('------> Config Sync Finish');

        return $_syncProcess ? Command::SUCCESS : Command::FAILURE;
    }
}
