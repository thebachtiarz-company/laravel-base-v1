<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Traits\Models;

use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
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
    public function scopeGetByPath(EloquentBuilder|QueryBuilder $builder, string $path): BuilderContract
    {
        $attribute = ConfigInterface::ATTRIBUTE_PATH;

        return $builder->where(DB::raw("BINARY `$attribute`"), $path);
    }
}
