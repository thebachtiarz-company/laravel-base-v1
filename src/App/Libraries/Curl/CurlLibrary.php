<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl;

use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;

use function app;
use function assert;

class CurlLibrary
{
    /**
     * Classes entity
     */
    protected array $classEntity = [];

    // ? Public Methods

    /**
     * Execute curl resolver
     *
     * @param array $data
     */
    public function execute(string $path, array $data = []): CurlResponseInterface
    {
        $curlInterface = app()->make($this->classEntityResolver($path));
        assert($curlInterface instanceof CurlInterface);

        return $curlInterface->execute($data);
    }

    // ? Protected Methods

    /**
     * Define class entity by path
     */
    protected function classEntityResolver(string $path): string
    {
        return @$this->classEntity[$path] ?? '';
    }

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
