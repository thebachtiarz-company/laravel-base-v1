<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Services;

use Illuminate\Support\Facades\Crypt;
use TheBachtiarz\Base\App\Services\AbstractService;
use TheBachtiarz\Base\BaseConfigInterface;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;
use TheBachtiarz\Base\Config\Models\Config;
use TheBachtiarz\Base\Config\Repositories\ConfigRepository;
use Throwable;

use function array_keys;
use function assert;
use function config;
use function gettype;
use function json_encode;
use function sprintf;
use function tbbaseconfig;

class ConfigService extends AbstractService
{
    /**
     * Constructor
     */
    public function __construct(
        protected ConfigRepository $configRepository,
    ) {
        $this->configRepository = $configRepository;
    }

    // ? Public Methods

    /**
     * Get config value
     */
    public function getConfigValue(string $path): mixed
    {
        $_result       = null;
        $_config       = new Config();
        $_errorMessage = null;

        try {
            $_config = $this->configRepository->getByPath($path);

            goto RESULT;
        } catch (Throwable $th) {
            $_errorMessage = $th->getMessage();
        }

        try {
            $_config->setPath($path)->setValue(config($path));

            goto RESULT;
        } catch (Throwable $th) {
            $_errorMessage = $th->getMessage();
        }

        RESULT:

        try {
            $_result = $_config->getValue();

            if ($_config->getIsEncrypt()) {
                $_result = Crypt::decrypt($_result);
            }
        } catch (Throwable $th) {
            $_errorMessage = $th->getMessage();
        }

        $this->setResponseData($_errorMessage ?? 'Config value', $_result);

        return $_result;
    }

    /**
     * Create or update config
     *
     * @param string|null $isEncrypt default: null | [ 1 => true, 2 => false ]
     */
    public function createOrUpdate(string $path, mixed $value, string|null $isEncrypt = null): ConfigInterface
    {
        $_actionMethod = 'create';

        try {
            $_config = $this->configRepository->getByPath($path);

            $_actionMethod = 'save';
        } catch (Throwable) {
            $_config = new Config();

            $_config->setPath($path)->setIsEncrypt(false);
        }

        if (gettype($value) === 'array') {
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
            $_config,
        );

        return $_config;
    }

    /**
     * Delete config
     */
    public function deleteConfig(string $path): bool
    {
        $_config = $this->configRepository->getByPath($path);
        assert($_config instanceof Config);

        return $_config->delete();
    }

    /**
     * Synchronize configs.
     *
     * Only sync for new config registered.
     */
    public function synchronizeConfig(): bool
    {
        $_result = false;

        try {
            $_configRegistered = tbbaseconfig(BaseConfigInterface::CONFIG_REGISTERED);

            foreach ($_configRegistered ?? [] as $key => $configRegisterName) {
                foreach (array_keys(config($configRegisterName)) ?? [] as $key => $configPath) {
                    $_config = new Config();
                    assert($_config instanceof ConfigInterface);

                    try {
                        $_config = $this->configRepository->getByPath("$configRegisterName.$configPath");
                    } catch (Throwable) {
                    }

                    $_configValue = $this->getConfigValue("$configRegisterName.$configPath");

                    if ($_config->getId()) {
                        config(["$configRegisterName.$configPath" => $_configValue]);

                        continue;
                    }

                    $this->createOrUpdate(path: "$configRegisterName.$configPath", value: $_configValue);
                }
            }

            $this->createOrUpdate(
                BaseConfigInterface::CONFIG_NAME . '.' . BaseConfigInterface::CONFIG_REGISTERED,
                $_configRegistered,
            );

            $_result = true;
        } catch (Throwable $th) {
            $this->log($th);
        } finally {
            $this->setResponseData(sprintf('%s synchronize new config', $_result ? 'Successfully' : 'Failed to'), []);

            return $_result;
        }
    }

    // ? Private Methods

    // ? Setter Modules
}
