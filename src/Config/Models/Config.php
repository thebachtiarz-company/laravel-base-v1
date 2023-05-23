<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Models;

use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;
use TheBachtiarz\Base\Config\Traits\Model\ConfigScopeTrait;

class Config extends Model implements ConfigInterface
{
    use ConfigScopeTrait;

    protected $table = self::TABLE_NAME;

    protected $fillable = self::ATTRIBUTES_FILLABLE;

    public function getId(): int|null
    {
        return $this->__get(self::ATTRIBUTE_ID);
    }

    public function getPath(): string|null
    {
        return $this->__get(self::ATTRIBUTE_PATH);
    }

    public function getIsEncrypt(): bool|null
    {
        return $this->__get(self::ATTRIBUTE_ISENCRYPT);
    }

    public function getValue(): mixed
    {
        return $this->__get(self::ATTRIBUTE_VALUE);
    }

    public function setId(int $id): self
    {
        $this->__set(self::ATTRIBUTE_ID, $id);

        return $this;
    }

    public function setPath(string $path): self
    {
        $this->__set(self::ATTRIBUTE_PATH, $path);

        return $this;
    }

    public function setIsEncrypt(bool $isEncrypt): self
    {
        $this->__set(self::ATTRIBUTE_ISENCRYPT, $isEncrypt);

        return $this;
    }

    public function setValue(mixed $value): self
    {
        $this->__set(self::ATTRIBUTE_VALUE, $value);

        return $this;
    }
}
