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
use function json_decode;
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
    }

    // ? Public Methods

    /**
     * Get config value
     */
    public function getConfigValue(string $path): mixed
    {
        $result       = null;
        $config       = new Config();
        $errorMessage = null;

        try {
            $config = $this->configRepository->getByPath($path);

            goto RESULT;
        } catch (Throwable $th) {
            $errorMessage = $th->getMessage();
        }

        try {
            $config->setPath($path)->setValue(config($path));

            goto RESULT;
        } catch (Throwable $th) {
            $errorMessage = $th->getMessage();
        }

        RESULT:

        try {
            $result = $config->getValue();

            if ($config->getIsEncrypt()) {
                $result = Crypt::decrypt($result);
            }
        } catch (Throwable $th) {
            $errorMessage = $th->getMessage();
        }

        try {
            if (@json_decode(json: $result)) {
                $result = json_decode(json: $result, associative: true);
            }
        } catch (Throwable) {
        }

        $this->setResponseData($errorMessage ?? 'Config value', $result);

        return $result;
    }

    /**
     * Create or update config
     *
     * @param string|null $isEncrypt default: null | [ 1 => true, 2 => false ]
     */
    public function createOrUpdate(string $path, mixed $value, string|null $isEncrypt = null): ConfigInterface
    {
        $actionMethod = 'create';

        try {
            $config = $this->configRepository->getByPath($path);

            $actionMethod = 'save';
        } catch (Throwable) {
            $config = new Config();

            $config->setPath($path)->setIsEncrypt(false);
        }

        if (gettype($value) === 'array') {
            $value = json_encode($value);
        }

        if (@$isEncrypt) {
            $encryptRequire = $isEncrypt === '1';

            $config->setIsEncrypt($encryptRequire);

            if ($encryptRequire) {
                $value = Crypt::encrypt($value);
            }
        }

        $config->setValue($value);

        $config = $this->configRepository->{$actionMethod}($config);

        $this->setResponseData(
            sprintf('Successfully %s config', $actionMethod === 'create' ? 'create new' : 'update'),
            $config,
        );

        return $config;
    }

    /**
     * Delete config
     */
    public function deleteConfig(string $path): bool
    {
        $config = $this->configRepository->getByPath($path);
        assert($config instanceof Config);

        return $config->delete();
    }

    /**
     * Synchronize configs.
     *
     * Only sync for new config registered.
     */
    public function synchronizeConfig(): bool
    {
        $result = false;

        try {
            $configRegistered = tbbaseconfig(BaseConfigInterface::CONFIG_REGISTERED);

            foreach ($configRegistered ?? [] as $key => $configRegisterName) {
                foreach (array_keys(config($configRegisterName) ?? []) ?? [] as $key => $configPath) {
                    $config = new Config();
                    assert($config instanceof ConfigInterface);

                    try {
                        $config = $this->configRepository->getByPath("$configRegisterName.$configPath");
                    } catch (Throwable) {
                    }

                    $configValue = $this->getConfigValue("$configRegisterName.$configPath");

                    if ($config->getId()) {
                        config(["$configRegisterName.$configPath" => $configValue]);

                        continue;
                    }

                    $this->createOrUpdate(path: "$configRegisterName.$configPath", value: $configValue);
                }
            }

            $this->createOrUpdate(
                BaseConfigInterface::CONFIG_NAME . '.' . BaseConfigInterface::CONFIG_REGISTERED,
                $configRegistered,
            );

            $result = true;
        } catch (Throwable $th) {
            $this->log($th);
        } finally {
            $this->setResponseData(sprintf('%s synchronize new config', $result ? 'Successfully' : 'Failed to'), []);

            return $result;
        }
    }

    // ? Private Methods

    // ? Setter Modules
}
