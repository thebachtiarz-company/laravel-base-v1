<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use TheBachtiarz\Base\App\Interfaces\Repositories\AbstractRepositoryInterface;
use TheBachtiarz\Base\App\Repositories\AbstractRepository;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;
use TheBachtiarz\Base\Config\Models\Config;

use function app;
use function assert;

class ConfigRepository extends AbstractRepository implements AbstractRepositoryInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modelEntity = app(Config::class);

        parent::__construct();
    }

    // ? Public Methods

    /**
     * Get by path
     */
    public function getByPath(string $path): ConfigInterface|null
    {
        $this->modelBuilder(modelBuilder: Config::getByPath($path));

        $config = $this->modelBuilder()->first();
        assert($config instanceof ConfigInterface || $config === null);

        if (! $config && $this->throwIfNullEntity()) {
            throw new ModelNotFoundException("Config with path '$path' not found");
        }

        return $config;
    }

    /**
     * Delete by path
     */
    public function deleteByPath(string $path): bool
    {
        $config = $this->getByPath($path);

        if (! $config) {
            throw new ModelNotFoundException('Failed to delete config');
        }

        return $this->deleteById($config->getId());
    }

    // ? Protected Methods

    protected function getByIdErrorMessage(): string|null
    {
        return "Config with id '%s' not found";
    }

    protected function createOrUpdateErrorMessage(): string|null
    {
        return 'Failed to %s config';
    }
}
