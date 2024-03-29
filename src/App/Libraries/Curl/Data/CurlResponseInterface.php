<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl\Data;

interface CurlResponseInterface
{
    // ? Public Methods

    /**
     * Get result response as array
     *
     * @return array
     */
    public function toArray(): array;

    // ? Getter Modules

    /**
     * Get http code
     */
    public function getHttpCode(): int|null;

    /**
     * Get response status
     */
    public function getStatus(): string;

    /**
     * Get response message
     */
    public function getMessage(): string;

    /**
     * Get response data
     */
    public function getData(string|null $attributekey = null): mixed;

    // ? Setter Modules

    /**
     * Set http code
     */
    public function setHttpCode(int|null $code): self;

    /**
     * Set response status
     */
    public function setStatus(string $status): self;

    /**
     * Set response message
     */
    public function setMessage(string $message): self;

    /**
     * Set response data
     */
    public function setData(mixed $data): self;
}
