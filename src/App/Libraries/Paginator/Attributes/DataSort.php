<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Paginator\Attributes;

use Illuminate\Support\Str;
use TheBachtiarz\Base\App\Libraries\Paginator\AbstractPaginator;

use function sprintf;

final class DataSort extends AbstractPaginator
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->dataSort = $this;
    }

    // ? Public Methods

    /**
     * Get result as array
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->sortAttribute ?? [] as $attribute => $type) {
            $result[] = Str::slug(title: sprintf('%s %s', $attribute, $type), separator: '_');
        }

        return $result;
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    /**
     * Get sort attribute
     */
    public function getSortAttribute(string|null $attribute = null): array
    {
        return @$this->sortAttribute[$attribute] ?? $this->sortAttribute;
    }

    // ? Setter Modules

    /**
     * Add sort attribute
     */
    public function addSortAttribute(string $attribute, string $type = 'ASC'): self
    {
        $this->sortAttribute[$attribute] = $type;

        return $this;
    }
}
