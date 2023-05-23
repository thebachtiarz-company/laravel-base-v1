<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Models;

use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\Base\App\Interfaces\Model\AbstractModelInterface;

abstract class AbstractModel extends Model implements AbstractModelInterface
{
    public function getData(string $attribute): mixed
    {
        return $this->__get($attribute);
    }

    public function setData(string $attribute, mixed $value): static
    {
        $this->__set($attribute, $value);

        return $this;
    }

    public function getId(): int|null
    {
        return $this->__get(self::ATTRIBUTE_ID);
    }

    public function getCreatedAt(): string|null
    {
        return $this->__get(self::ATTRIBUTE_CREATEDAT);
    }

    public function getUpdatedAt(): string|null
    {
        return $this->__get(self::ATTRIBUTE_UPDATEDAT);
    }

    public function setId(int $id): static
    {
        $this->__set(self::ATTRIBUTE_ID, $id);

        return $this;
    }
}
