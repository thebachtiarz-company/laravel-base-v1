<?php

namespace TheBachtiarz\Base\Config\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TheBachtiarz\Base\App\Repositories\AbstractRepository;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;
use TheBachtiarz\Base\Config\Models\Config;

class ConfigRepository extends AbstractRepository
{
    //

    /**
     * Get by id
     *
     * @param integer $id
     * @return ConfigInterface
     */
    public function getById(int $id): ConfigInterface
    {
        $_config = Config::find($id);

        if (!$_config) throw new ModelNotFoundException("Config with id '$id' not found");

        return $_config;
    }

    /**
     * Get by path
     *
     * @param string $path
     * @return ConfigInterface
     */
    public function getByPath(string $path): ConfigInterface
    {
        $_config = Config::getByPath($path)->first();

        if (!$_config) throw new ModelNotFoundException("Config with path '$path' not found");

        return $_config;
    }

    /**
     * Create new config
     *
     * @param ConfigInterface $configInterface
     * @return ConfigInterface
     */
    public function create(ConfigInterface $configInterface): ConfigInterface
    {
        /** @var Model $configInterface */
        /** @var ConfigInterface $_create */
        $_create = $this->createFromModel($configInterface);

        if (!$_create) throw new ModelNotFoundException("Failed to create new config");

        return $_create;
    }

    /**
     * Save current config
     *
     * @param ConfigInterface $configInterface
     * @return ConfigInterface
     */
    public function save(ConfigInterface $configInterface): ConfigInterface
    {
        /** @var Model|ConfigInterface $configInterface */
        $_config = $configInterface->save();

        if (!$_config) throw new ModelNotFoundException("Failed to savecurrent config");

        return $configInterface;
    }

    /**
     * Delete by id
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteById(int $id): bool
    {
        /** @var Model|ConfigInterface $_config */
        $_config = $this->getById($id);

        return $_config->delete();
    }

    /**
     * Delete by path
     *
     * @param string $path
     * @return boolean
     */
    public function deleteByPath(string $path): bool
    {
        /** @var Model $_config */
        $_config = $this->getByPath($path);

        return $_config->delete();
    }
}
