<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use TheBachtiarz\Base\App\Helpers\CommandHelper;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;
use Throwable;

use function date;
use function explode;
use function is_dir;
use function mkdir;
use function tbdirlocation;

class BackupLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected string $signature = 'thebachtiarz:base:backup:log';

    /**
     * The console command description.
     */
    protected string $description = 'Backup application logger files';

    /**
     * Constructor
     */
    public function __construct(
        protected CommandHelper $commandHelper,
        protected LogLibrary $logLibrary,
    ) {
        parent::__construct();

        $this->commandHelper = $commandHelper;
        $this->logLibrary    = $logLibrary;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $result = Command::INVALID;

        try {
            $this->logLibrary->log('======> Backup application logger files, started...');
            $this->info('======> Execute application backup logger files');

            /**
             * Set application to maintenance
             */
            $this->commandHelper->phpArtisan('down', '======> Application now in maintenance mode');
            $this->info('======> Application now in maintenance mode');

            /**
             * Execute backup logger files
             */
            $dirTarget  = 'log';
            $dirOutput  = 'backup/log';
            $fileOutput = 'tar_' . date('Ymd') . '_' . date('His');
            $this->createDirectory($dirOutput);
            (new Process(explode(' ', "tar -zcf $dirOutput/$fileOutput $dirTarget"), tbdirlocation()))->run();
            $this->logLibrary->log('======> Logger files backup finish');
            $this->info('======> Logger files backup finish');

            /**
             * Delete old logger files
             */
            (new Process(explode(' ', "rm -rf $dirTarget"), tbdirlocation()))->run();
            $this->createDirectory($dirTarget);
            $this->logLibrary->log('======> Delete old logger files');
            $this->info('======> Delete old logger files');

            /**
             * Set application to live
             */
            $this->commandHelper->phpArtisan('up', '======> Application now is Live');
            $this->info('======> Application now is Live');

            $this->logLibrary->log('======> Backup logger files, finished...');
            $this->info('======> Finish backup logger files');

            $result = Command::SUCCESS;
        } catch (Throwable $th) {
            $this->logLibrary->log($th);

            $result = Command::FAILURE;
        } finally {
            $this->logLibrary->log('');

            return $result;
        }
    }

    /**
     * Create directory
     */
    private function createDirectory(string $directoryPath): void
    {
        if (is_dir(tbdirlocation($directoryPath))) {
            return;
        }

        mkdir(tbdirlocation($directoryPath), 0755, true);
    }
}
