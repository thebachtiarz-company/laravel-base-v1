<?php

namespace TheBachtiarz\Base\App\Libraries\Curl\Data;

interface CurlResponseInterface
{
    //

    // ? Public Methods
    /**
     * Get result response as array
     *
     * @return array
     */
    public function toArray(): array;

    // ? Getter Modules
    /**
     * Get status code
     *
     * @return integer|null
     */
    public function getCode(): ?int;

    /**
     * Get response status
     *
     * @return boolean
     */
    public function getStatus(): bool;

    /**
     * Get response message
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Get response data
     *
     * @param string|null $attributekey
     * @return mixed
     */
    public function getData(?string $attributekey = null): mixed;

    // ? Setter Modules
    /**
     * Set status code
     *
     * @param integer|null $code
     * @return self
     */
    public function setCode(?int $code): self;

    /**
     * Set response status
     *
     * @param boolean $status
     * @return self
     */
    public function setStatus(bool $status): self;

    /**
     * Set response message
     *
     * @param string $message
     * @return self
     */
    public function setMessage(string $message): self;

    /**
     * Set response data
     *
     * @param mixed $data
     * @return self
     */
    public function setData(mixed $data): self;
}
