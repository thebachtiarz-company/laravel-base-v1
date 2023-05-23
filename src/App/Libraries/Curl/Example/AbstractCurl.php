<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl\Example;

use TheBachtiarz\Base\App\Libraries\Curl\AbstractCurl as BaseAbstractCurl;

abstract class AbstractCurl extends BaseAbstractCurl
{
    protected function urlDomainResolver(): string
    {
        $subPaths = ['create-new-customer' => 'rest/api/v1/customer/create'];

        $this->url = 'https://localhost.test/' . $subPaths[$this->path];

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
