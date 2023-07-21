<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Interfaces\Models;

use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

interface AbstractModelInterface
{
    public const ATTRIBUTE_ID        = 'id';
    public const ATTRIBUTE_CREATEDAT = 'created_at';
    public const ATTRIBUTE_UPDATEDAT = 'updated_at';

    // ? Public Methods

    /**
     * Get data
     */
    public function getData(string $attribute): mixed;

    /**
     * Set data
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
    public function getCreatedAt(): mixed;

    /**
     * Get updated at
     */
    public function getUpdatedAt(): mixed;

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
    public function setCreatedAt(string $createdAt);

    /**
     * Set updated at
     *
     * @return static
     */
    public function setUpdatedAt(string $updatedAt);

    // ? Map Modules

    /**
     * Get entity simple map
     *
     * @param array $attributes
     *
     * @return array
     */
    public function simpleListMap(array $attributes = []): array;

    // ? Scope Modules

    /**
     * Get entity by attribute
     */
    public function scopeGetByAttribute(
        EloquentBuilder|QueryBuilder $builder,
        string $column,
        mixed $value,
        string $operator = '=',
    ): BuilderContract;
}
