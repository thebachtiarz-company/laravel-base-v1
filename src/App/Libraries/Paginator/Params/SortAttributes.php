<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Paginator\Params;

use function mb_strlen;

class SortAttributes
{
    /**
     * Attribute sort attribute
     */
    public const ATTRIBUTE_SORTATTRIBUTE = 'sortAttribute';

    /**
     * Attribute sort type
     */
    public const ATTRIBUTE_SORTTYPE = 'sortType';

    /**
     * Sort attribute name
     */
    protected string $sortAttribute = '';

    /**
     * Sort type direction
     */
    protected string $sortType = '';

    /**
     * Constructor
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setSortAttribute(@$attributes[self::ATTRIBUTE_SORTATTRIBUTE] ?? $this->sortAttribute);
        $this->setSortType(
            mb_strlen($this->sortAttribute)
                ? @$attributes[self::ATTRIBUTE_SORTTYPE] ?? 'ASC'
                : $this->sortType,
        );
    }

    // ? Public Methods

    /**
     * Get result as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::ATTRIBUTE_SORTATTRIBUTE => $this->getSortAttribute(),
            self::ATTRIBUTE_SORTTYPE => $this->getSortType(),
        ];
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    /**
     * Get sort attribute
     */
    public function getSortAttribute(): string
    {
        return $this->sortAttribute;
    }

    /**
     * Get sort type
     */
    public function getSortType(): string
    {
        return $this->sortType;
    }

    // ? Setter Modules

    /**
     * Set sort attribute
     */
    public function setSortAttribute(string $sortAttribute): self
    {
        $this->sortAttribute = $sortAttribute;

        return $this;
    }

    /**
     * Set sort type
     */
    public function setSortType(string $sortType): self
    {
        $this->sortType = $sortType;

        return $this;
    }
}
