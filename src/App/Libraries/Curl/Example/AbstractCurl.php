<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl\Example;

use TheBachtiarz\Base\App\Libraries\Curl\AbstractCurl as BaseAbstractCurl;

use function sprintf;

abstract class AbstractCurl extends BaseAbstractCurl
{
    protected function urlDomainResolver(): string
    {
        $this->url = sprintf('%s/%s', 'https://localhost.test', $this->getSubUrl());

        return $this->url;
    }

    /**
     * {@inheritDoc}
     */
    protected function bodyDataResolver(): array
    {
        return $this->body;
    }
}
