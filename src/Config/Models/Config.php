<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Models;

use TheBachtiarz\Base\App\Models\AbstractModel;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;
use TheBachtiarz\Base\Config\Traits\Models\ConfigScopeTrait;

class Config extends AbstractModel implements ConfigInterface
{
    use ConfigScopeTrait;

    /**
     * Constructor
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(self::TABLE_NAME);
        $this->fillable(self::ATTRIBUTE_FILLABLE);

        parent::__construct($attributes);
    }

    // ? Getter Modules

    /**
     * Get path
     */
    public function getPath(): string|null
    {
        return $this->__get(self::ATTRIBUTE_PATH);
    }

    /**
     * Get is encrypt
     */
    public function getIsEncrypt(): bool|null
    {
        return $this->__get(self::ATTRIBUTE_ISENCRYPT);
    }

    /**
     * Get value
     */
    public function getValue(): mixed
    {
        return $this->__get(self::ATTRIBUTE_VALUE);
    }

    // ? Setter Modules

    /**
     * Set path
     */
    public function setPath(string $path): self
    {
        $this->__set(self::ATTRIBUTE_PATH, $path);

        return $this;
    }

    /**
     * Set is encrypt
     */
    public function setIsEncrypt(bool $isEncrypt): self
    {
        $this->__set(self::ATTRIBUTE_ISENCRYPT, $isEncrypt);

        return $this;
    }

    /**
     * Set value
     */
    public function setValue(mixed $value): self
    {
        $this->__set(self::ATTRIBUTE_VALUE, $value);

        return $this;
    }
}
