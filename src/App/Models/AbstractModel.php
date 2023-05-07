<?php

namespace TheBachtiarz\Base\App\Models;

use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\Base\App\Interfaces\Model\AbstractModelInterface;

abstract class AbstractModel extends Model implements AbstractModelInterface
{
    //

    // ? Public Methods
    /**
     * {@inheritDoc}
     */
    public function getData(string $attribute): mixed
    {
        return $this->__get($attribute);
    }

    /**
     * {@inheritDoc}
     */
    public function setData(string $attribute, mixed $value): static
    {
        $this->__set($attribute, $value);

        return $this;
    }

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
    public function getCreatedAt(): ?string
    {
        return $this->__get(self::ATTRIBUTE_CREATEDAT);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt(): ?string
    {
        return $this->__get(self::ATTRIBUTE_UPDATEDAT);
    }

    // ? Setter Modules
    /**
     * {@inheritDoc}
     */
    public function setId(int $id): static
    {
        $this->__set(self::ATTRIBUTE_ID, $id);

        return $this;
    }
}
