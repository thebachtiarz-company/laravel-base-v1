<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Interfaces\Model;

interface AbstractModelInterface
{
    public const ATTRIBUTE_ID        = 'id';
    public const ATTRIBUTE_CREATEDAT = 'created_at';
    public const ATTRIBUTE_UPDATEDAT = 'updated_at';

    // ? Public Methods

    /**
     * Get data.
     *
     * Get by attribute or return whole data.
     */
    public function getData(string $attribute): mixed;

    /**
     * Set data.
     *
     * Set data using attribute and value exist.
     *
     * @return static
     */
    public function setData(string $attribute, mixed $value): static;

    // ? Getter Modules

    /**
     * Get id
     */
    public function getId(): int|null;

    /**
     * Get created at
     */
    public function getCreatedAt(): string|null;

    /**
     * Get updated at
     */
    public function getUpdatedAt(): string|null;

    // ? Setter Modules

    /**
     * Set id
     *
     * @return static
     */
    public function setId(int $id): static;

    /**
     * Set created at
     *
     * @return static
     */
    public function setCreatedAt(string $createdAt): static;

    /**
     * Set updated at
     *
     * @return static
     */
    public function setUpdatedAt(string $updatedAt): static;
}
