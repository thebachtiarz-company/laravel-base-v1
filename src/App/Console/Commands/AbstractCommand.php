<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Console\Commands;

use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use TheBachtiarz\Base\App\Helpers\CarbonHelper;
use Throwable;

use function sprintf;
use function throw_if;

abstract class AbstractCommand extends Command
{
    /**
     * Command title
     */
    protected string $commandTitle = '';

    /**
     * Command process
     */
    abstract public function commandProcess(): bool;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $result = self::INVALID;

        $this->info(sprintf('======> %s started...', $this->commandTitle));

        $timeStart = CarbonHelper::anyConvDateToTimestamp();

        try {
            $execute = $this->commandProcess();

            throw_if(! $execute, 'Exception', sprintf('Failed to %s', $this->commandTitle));

            $result = self::SUCCESS;
        } catch (Throwable $th) {
            $this->error(sprintf('======> Error: %s', $th->getMessage()));

            $result = self::FAILURE;
        } finally {
            $timeEnd = CarbonHelper::anyConvDateToTimestamp();

            $outputType = $result === self::SUCCESS ? 'info' : 'error';

            $this->{$outputType}(sprintf(
                '======> %s execute %s. Usage time: %s',
                $result === self::SUCCESS ? 'Successfully' : 'Failed to',
                $this->commandTitle,
                CarbonInterval::seconds($timeEnd - $timeStart)->cascade()->forHumans(),
            ));

            return $result;
        }
    }
}
