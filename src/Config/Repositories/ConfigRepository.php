<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TheBachtiarz\Base\App\Repositories\AbstractRepository;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;
use TheBachtiarz\Base\Config\Models\Config;

use function assert;

class ConfigRepository extends AbstractRepository
{
    /**
     * Get by id
     */
    public function getById(int $id): ConfigInterface
    {
        $config = Config::find($id);

        if (! $config) {
            throw new ModelNotFoundException("Config with id '$id' not found");
        }

        return $config;
    }

    /**
     * Get by path
     */
    public function getByPath(string $path): ConfigInterface
    {
        $config = Config::getByPath($path)->first();

        if (! $config) {
            throw new ModelNotFoundException("Config with path '$path' not found");
        }

        return $config;
    }

    /**
     * Create new config
     */
    public function create(ConfigInterface $configInterface): ConfigInterface
    {
        /** @var Model $configInterface */
        $create = $this->createFromModel($configInterface);
        assert($create instanceof ConfigInterface);

        if (! $create) {
            throw new ModelNotFoundException('Failed to create new config');
        }

        return $create;
    }

    /**
     * Save current config
     */
    public function save(ConfigInterface $configInterface): ConfigInterface
    {
        /** @var Model|ConfigInterface $configInterface */
        $config = $configInterface->save();

        if (! $config) {
            throw new ModelNotFoundException('Failed to savecurrent config');
        }

        return $configInterface;
    }

    /**
     * Delete by id
     */
    public function deleteById(int $id): bool
    {
        $config = $this->getById($id);
        assert($config instanceof Model);

        return $config->delete();
    }

    /**
     * Delete by path
     */
    public function deleteByPath(string $path): bool
    {
        $config = $this->getByPath($path);
        assert($config instanceof Model);

        return $config->delete();
    }
}
