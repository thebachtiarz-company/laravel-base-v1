<?php

namespace TheBachtiarz\Base\App\Libraries\Curl\Data;

class CurlResponse implements CurlResponseInterface
{
    //

    /**
     * Status code
     *
     * @var integer|null
     */
    private ?int $code = null;

    /**
     * Status
     *
     * @var boolean
     */
    private bool $status = false;

    /**
     * Message
     *
     * @var string
     */
    private string $message = '';

    /**
     * Data
     *
     * @var mixed
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
            'data' => $this->getData()
        ];
    }

    // ? Private Methods

    // ? Getter Modules
    /**
     * {@inheritDoc}
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * {@inheritDoc}
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * {@inheritDoc}
     */
    public function getData(?string $attributekey = null): mixed
    {
        try {
            return $this->data[$attributekey];
        } catch (\Throwable $th) {
            return $this->data;
        }
    }

    // ? Setter Modules
    /**
     * {@inheritDoc}
     */
    public function setCode(?int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setData(mixed $data): self
    {
        $this->data = $data;

        return $this;
    }
}
