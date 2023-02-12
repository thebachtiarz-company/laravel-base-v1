<?php

namespace TheBachtiarz\Base\Config\Services;

use TheBachtiarz\Base\App\Services\AbstractService;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;
use TheBachtiarz\Base\Config\Models\Config;
use TheBachtiarz\Base\Config\Repositories\ConfigRepository;

class ConfigService extends AbstractService
{
    //

    /**
     * Constructor
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(
        protected ConfigRepository $configRepository
    ) {
        $this->configRepository = $configRepository;
    }

    // ? Public Methods
    /**
     * Get config value
     *
     * @param string $path
     * @return mixed
     */
    public function getConfigValue(string $path): mixed
    {
        $_result = null;
        $_config = new Config;
        $_errorMessage = null;

        try {
            $_config = $this->configRepository->getByPath($path);
        } catch (\Throwable $th) {
            $_errorMessage = $th->getMessage();
        }

        try {
            $_config->setPath($path)->setValue(config($path));
        } catch (\Throwable $th) {
            $_errorMessage = $th->getMessage();
        }

        try {
            $_result = $_config->getValue();
        } catch (\Throwable $th) {
            $_errorMessage = $th->getMessage();
        }

        static::$responseHelper::setResultService($_errorMessage ?? 'Config value', $_result);

        return $_result;
    }

    /**
     * Create or update config
     *
     * @param string $path
     * @param mixed $value
     * @param string|null $isEncrypt default: null | [ 1 => true, 2 => false ]
     * @return ConfigInterface
     */
    public function createOrUpdate(string $path, mixed $value, ?string $isEncrypt = null): ConfigInterface
    {
        $_actionMethod = 'create';

        try {
            $_config = $this->configRepository->getByPath($path);

            $_actionMethod = 'save';
        } catch (\Throwable $th) {
            $_config = new Config();

            $_config->setPath($path)->setIsEncrypt(false);
        }

        if (gettype($value) == 'array') {
            $value = json_encode($value);
        }

        $_config->setValue($value);

        if (@$isEncrypt) {
            $_config->setIsEncrypt($isEncrypt === '1');
        }

        $_config = $this->configRepository->{$_actionMethod}($_config);

        static::$responseHelper::setResultService(
            sprintf('Successfully %s config', $_actionMethod === 'create' ? 'create new' : 'update'),
            $_config
        );

        return $_config;
    }

    /**
     * Delete config
     *
     * @param string $path
     * @return boolean
     */
    public function deleteConfig(string $path): bool
    {
        /** @var Config $_config */
        $_config = $this->configRepository->getByPath($path);

        return $_config->delete();
    }

    /**
     * Synchronize configs.
     *
     * Only sync for new config registered.
     *
     * @return boolean
     */
    public function synchronizeConfig(): bool
    {
        $_result = false;

        try {
            $_baseConfigName = \TheBachtiarz\Base\BaseConfigInterface::CONFIG_NAME;
            $_baseConfigRegistered = \TheBachtiarz\Base\BaseConfigInterface::CONFIG_REGISTERED;

            $_configRegistered = $this->getConfigValue("$_baseConfigName.$_baseConfigRegistered");

            foreach ($_configRegistered ?? [] as $key => $configRegisterName) {
                foreach (array_keys(config($configRegisterName)) ?? [] as $key => $configPath) {
                    $_config = new Config;

                    try {
                        $_config = $this->configRepository->getByPath("$configRegisterName.$configPath");
                    } catch (\Throwable $th) {
                    }

                    if ($_config->getId()) continue;

                    $_configValue = $this->getConfigValue("$configRegisterName.$configPath");

                    $this->createOrUpdate(path: "$configRegisterName.$configPath", value: $_configValue);
                }
            }

            $_result = true;
        } catch (\Throwable $th) {
        } finally {
            static::$responseHelper::setResultService(sprintf('%s synchronize new config', $_result ? 'Successfully' : 'Failed to'), []);

            return $_result;
        }
    }

    // ? Private Methods

    // ? Setter Modules
}
