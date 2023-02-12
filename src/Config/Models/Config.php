<?php

namespace TheBachtiarz\Base\Config\Models;

use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;
use TheBachtiarz\Base\Config\Traits\Model\ConfigScopeTrait;

class Config extends Model implements ConfigInterface
{
    use ConfigScopeTrait;

    /**
     * {@inheritDoc}
     */
    protected $table = self::TABLE_NAME;

    /**
     * {@inheritDoc}
     */
    protected $fillable = self::ATTRIBUTES_FILLABLE;

    // ? Getter Modules
    /**
     * {@inheritDoc}
     */
    public function getId(): ?int
    {
        return $this->__get(self::ATTRIBUTE_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getPath(): ?string
    {
        return $this->__get(self::ATTRIBUTE_PATH);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsEncrypt(): ?bool
    {
        return $this->__get(self::ATTRIBUTE_ISENCRYPT);
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): mixed
    {
        return $this->__get(self::ATTRIBUTE_VALUE);
    }

    // ? Setter Modules
    /**
     * {@inheritDoc}
     */
    public function setId(int $id): self
    {
        $this->__set(self::ATTRIBUTE_ID, $id);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setPath(string $path): self
    {
        $this->__set(self::ATTRIBUTE_PATH, $path);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setIsEncrypt(bool $isEncrypt): self
    {
        $this->__set(self::ATTRIBUTE_ISENCRYPT, $isEncrypt);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setValue(mixed $value): self
    {
        $this->__set(self::ATTRIBUTE_VALUE, $value);

        return $this;
    }
}
