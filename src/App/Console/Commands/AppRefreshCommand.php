<?php

namespace TheBachtiarz\Base\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use TheBachtiarz\Base\App\Helpers\CommandHelper;
use TheBachtiarz\Base\App\Libraries\Cache\CacheLibrary;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;
use TheBachtiarz\Base\BaseConfigInterface;
use TheBachtiarz\Base\Config\Services\ConfigService;

class AppRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thebachtiarz:base:app:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the app for clean all cache etc.';

    /**
     * Constructor
     *
     * @param Composer $composer
     * @param ConfigService $configService
     * @param CacheLibrary $cacheLibrary
     * @param CommandHelper $commandHelper
     * @param LogLibrary $logLibrary
     */
    public function __construct(
        protected Composer $composer,
        protected ConfigService $configService,
        protected CacheLibrary $cacheLibrary,
        protected CommandHelper $commandHelper,
        protected LogLibrary $logLibrary
    ) {
        parent::__construct();
        $this->composer = $composer;
        $this->configService = $configService;
        $this->cacheLibrary = $cacheLibrary;
        $this->commandHelper = $commandHelper;
        $this->logLibrary = $logLibrary;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = Command::INVALID;

        try {
            $this->logLibrary->log('======> Maintenance server daily, started...');
            $this->info('======> Execute app refresh maintenance');

            /**
             * Set application to maintenance
             */
            $this->commandHelper->phpArtisan('down', '======> Application now in maintenance mode');
            $this->info('======> Application now in maintenance mode');

            /**
             * Keep application caches
             * TODO: unfinished
             */
            // $this->logLibrary->log('======> Keeping cache');
            // $this->info('======> Keeping cache');

            /**
             * Run command before
             */
            foreach (@$this->getStringableConfig(BaseConfigInterface::CONFIG_NAME . '.app_refresh_artisan_commands_before') ?? [] as $keyCmdBfr => $commandBefore) {
                $this->commandHelper->phpArtisan($commandBefore['command'], $commandBefore['message']);
                $this->info($commandBefore['message']);
            }

            /**
             * Synchronize config
             */
            $this->configService->synchronizeConfig();
            $this->logLibrary->log('======> Synchronize application configs');
            $this->info('======> Synchronize application configs');

            /**
             * Cache service executions
             */
            $this->cacheLibrary->createCaches();
            $this->logLibrary->log('======> Create module caches in application');
            $this->info('======> Create module caches in application');

            /**
             * Composer dump autoload
             */
            $this->composer->dumpAutoloads();
            $this->logLibrary->log('======> Composer dump-autoload');
            $this->info('======> Composer dump-autoload');

            /**
             * Run command after
             */
            foreach (@$this->getStringableConfig(BaseConfigInterface::CONFIG_NAME . '.app_refresh_artisan_commands_after') ?? [] as $keyCmdAft => $commandAfter) {
                $this->commandHelper->phpArtisan($commandAfter['command'], $commandAfter['message']);
                $this->info($commandAfter['message']);
            }

            /**
             * Restore application caches
             * TODO: unfinished
             */
            // $this->logLibrary->log('======> Restoring cache');
            // $this->info('======> Restoring cache');

            /**
             * Set application to live
             */
            $this->commandHelper->phpArtisan('up', '======> Application now is Live');
            $this->info('======> Application now is Live');

            $this->logLibrary->log('======> Maintenance server daily, finished...');
            $this->info('======> Finish app refresh maintenance');

            $result = Command::SUCCESS;
        } catch (\Throwable $th) {
            $this->logLibrary->log($th);

            $result = Command::FAILURE;
        } finally {
            $this->logLibrary->log('');

            return $result;
        }
    }

    /**
     * Get stringable config
     *
     * @param string $configName
     * @return array|null
     */
    private function getStringableConfig(string $configName): ?array
    {
        $config = tbconfigvalue($configName);

        try {
            $config = json_decode($config, true);
        } catch (\Throwable $th) {
        }

        return $config;
    }
}
