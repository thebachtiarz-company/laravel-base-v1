<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Traits\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;

/**
 * Config Scope Trait
 */
trait ConfigScopeTrait
{
    /**
     * Get by path
     */
    public function scopeGetByPath(Builder $builder, string $path): Builder
    {
        $attribute = ConfigInterface::ATTRIBUTE_PATH;

        return $builder->where(DB::raw("BINARY `$attribute`"), $path);
    }
}
