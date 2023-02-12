<?php

namespace TheBachtiarz\Base\Config\Traits\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use TheBachtiarz\Base\Config\Interfaces\ConfigInterface;

/**
 * Config Scope Trait
 */
trait ConfigScopeTrait
{
    //

    /**
     * Get by path
     *
     * @param Builder $builder
     * @param string $path
     * @return Builder
     */
    public function scopeGetByPath(Builder $builder, string $path): Builder
    {
        $_attribute = ConfigInterface::ATTRIBUTE_PATH;

        return $builder->where(DB::raw("BINARY `$_attribute`"), $path);
    }
}
