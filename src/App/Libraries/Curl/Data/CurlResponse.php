<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl\Data;

use TheBachtiarz\Base\App\Interfaces\Helpers\ResponseInterface;
use Throwable;

class CurlResponse implements CurlResponseInterface
{
    /**
     * Response http code
     */
    private int|null $httpCode = 200;

    /**
     * Response status
     */
    private string $status = 'error';

    /**
     * Response message
     */
    private string $message = '';

    /**
     * Response data
     */
    private mixed $data = null;

    /**
     * Constructor
     *
     * @param array $responseData
     */
    public function __construct(array $responseData = [])
    {
        $this->setHttpCode(@$responseData[ResponseInterface::ATTRIBUTE_HTTPCODE] ?? $this->httpCode);
        $this->setStatus(@$responseData[ResponseInterface::ATTRIBUTE_STATUS] ?? $this->status);
        $this->setMessage(@$responseData[ResponseInterface::ATTRIBUTE_MESSAGE] ?? $this->message);
        $this->setData(@$responseData[ResponseInterface::ATTRIBUTE_DATA] ?? $this->data);
    }

    // ? Public Methods

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            ResponseInterface::ATTRIBUTE_HTTPCODE => $this->getHttpCode(),
            ResponseInterface::ATTRIBUTE_STATUS => $this->getStatus(),
            ResponseInterface::ATTRIBUTE_MESSAGE => $this->getMessage(),
            ResponseInterface::ATTRIBUTE_DATA => $this->getData(),
        ];
    }

    // ? Private Methods


    public function getHttpCode(): int|null
    {
        return $this->httpCode;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(string|null $attributekey = null): mixed
    {
        try {
            return $this->data[$attributekey];
        } catch (Throwable) {
            return $this->data;
        }
    }

    public function setHttpCode(int|null $code): self
    {
        $this->httpCode = $code;

        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function setData(mixed $data): self
    {
        $this->data = $data;

        return $this;
    }
}
