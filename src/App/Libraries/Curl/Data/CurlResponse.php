<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl\Data;

use Throwable;

class CurlResponse implements CurlResponseInterface
{
    /**
     * Status code
     */
    private int|null $code = null;

    /**
     * Status
     */
    private bool $status = false;

    /**
     * Message
     */
    private string $message = '';

    /**
     * Data
     */
    private mixed $data = null;

    /**
     * Constructor
     *
     * @param array $responseData
     */
    public function __construct(array $responseData = [])
    {
        $this->setStatus(@$responseData['status'] ?? $this->status);
        $this->setMessage(@$responseData['message'] ?? $this->message);
        $this->setData(@$responseData['data'] ?? $this->data);
        $this->setCode(@$responseData['code'] ?? $this->code);
    }

    // ? Public Methods

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'status' => $this->getStatus(),
            'message' => $this->getMessage(),
            'data' => $this->getData(),
        ];
    }

    // ? Private Methods


    public function getCode(): int|null
    {
        return $this->code;
    }

    public function getStatus(): bool
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

    public function setCode(int|null $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function setStatus(bool $status): self
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
