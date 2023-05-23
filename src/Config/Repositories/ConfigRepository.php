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
        $_config = Config::find($id);

        if (! $_config) {
            throw new ModelNotFoundException("Config with id '$id' not found");
        }

        return $_config;
    }

    /**
     * Get by path
     */
    public function getByPath(string $path): ConfigInterface
    {
        $_config = Config::getByPath($path)->first();

        if (! $_config) {
            throw new ModelNotFoundException("Config with path '$path' not found");
        }

        return $_config;
    }

    /**
     * Create new config
     */
    public function create(ConfigInterface $configInterface): ConfigInterface
    {
        /** @var Model $configInterface */
        $_create = $this->createFromModel($configInterface);
        assert($_create instanceof ConfigInterface);

        if (! $_create) {
            throw new ModelNotFoundException('Failed to create new config');
        }

        return $_create;
    }

    /**
     * Save current config
     */
    public function save(ConfigInterface $configInterface): ConfigInterface
    {
        /** @var Model|ConfigInterface $configInterface */
        $_config = $configInterface->save();

        if (! $_config) {
            throw new ModelNotFoundException('Failed to savecurrent config');
        }

        return $configInterface;
    }

    /**
     * Delete by id
     */
    public function deleteById(int $id): bool
    {
        $_config = $this->getById($id);
        assert($_config instanceof Model);

        return $_config->delete();
    }

    /**
     * Delete by path
     */
    public function deleteByPath(string $path): bool
    {
        $_config = $this->getByPath($path);
        assert($_config instanceof Model);

        return $_config->delete();
    }
}
