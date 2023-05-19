<?php

namespace TheBachtiarz\Base\App\Libraries\Curl;

use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;

class CurlLibrary
{
    //

    /**
     * Class entity
     *
     * @var array
     */
    protected array $classEntity = [];

    // ? Public Methods
    /**
     * Execute curl resolver
     *
     * @param string $path
     * @param array $data
     * @return CurlResponseInterface
     */
    public function execute(string $path, array $data = []): CurlResponseInterface
    {
        /** @var CurlInterface $curlInterface */
        $curlInterface = app()->make($this->classEntityResolver($path));

        return $curlInterface->execute($data);
    }

    // ? Protected Methods
    /**
     * Define class entity by path
     *
     * @param string $path
     * @return string
     */
    protected function classEntityResolver(string $path): string
    {
        return @$this->classEntity[$path] ?? '';
    }

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
