<?php

namespace TheBachtiarz\Base\Config\Services;

use Illuminate\Support\Facades\Crypt;
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

            goto RESULT;
        } catch (\Throwable $th) {
            $_errorMessage = $th->getMessage();
        }

        try {
            $_config->setPath($path)->setValue(config($path));

            goto RESULT;
        } catch (\Throwable $th) {
            $_errorMessage = $th->getMessage();
        }

        RESULT:

        try {
            $_result = $_config->getValue();

            if ($_config->getIsEncrypt()) {
                $_result = Crypt::decrypt($_result);
            }
        } catch (\Throwable $th) {
            $_errorMessage = $th->getMessage();
        }

        $this->setResponseData($_errorMessage ?? 'Config value', $_result);

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

        if (@$isEncrypt) {
            $_encryptRequire = $isEncrypt === '1';

            $_config->setIsEncrypt($_encryptRequire);

            if ($_encryptRequire) {
                $value = Crypt::encrypt($value);
            }
        }

        $_config->setValue($value);

        $_config = $this->configRepository->{$_actionMethod}($_config);

        $this->setResponseData(
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
            $_configRegistered = tbbaseconfig(\TheBachtiarz\Base\BaseConfigInterface::CONFIG_REGISTERED);

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

            $this->createOrUpdate(
                \TheBachtiarz\Base\BaseConfigInterface::CONFIG_NAME . '.' . \TheBachtiarz\Base\BaseConfigInterface::CONFIG_REGISTERED,
                $_configRegistered
            );

            $_result = true;
        } catch (\Throwable $th) {
            $this->log($th);
        } finally {
            $this->setResponseData(sprintf('%s synchronize new config', $_result ? 'Successfully' : 'Failed to'), []);

            return $_result;
        }
    }

    // ? Private Methods

    // ? Setter Modules
}
