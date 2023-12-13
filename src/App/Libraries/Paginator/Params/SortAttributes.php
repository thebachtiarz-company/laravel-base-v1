<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Paginator\Params;

use Illuminate\Support\Str;

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
        $this->setSortAttribute($this->sortAttributeSanitize(@$attributes[self::ATTRIBUTE_SORTATTRIBUTE]));
        $this->setSortType($this->sortTypeSanitize(@$attributes[self::ATTRIBUTE_SORTTYPE]));
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

    /**
     * Sanitize input sort attribute
     */
    private function sortAttributeSanitize(string|null $input = null): string
    {
        return Str::slug(title: $input ?? $this->sortAttribute, separator: '_');
    }

    /**
     * Sanitize input sort type
     */
    private function sortTypeSanitize(string|null $input = null): string
    {
        return mb_strlen($this->sortAttribute)
            ? Str::slug(title: $input ?? 'ASC', separator: '_')
            : $this->sortType;
    }

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
