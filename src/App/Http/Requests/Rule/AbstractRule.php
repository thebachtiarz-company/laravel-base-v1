<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Http\Requests\Rule;

abstract class AbstractRule
{
    /**
     * Rules
     *
     * @return array
     */
    abstract public static function rules(): array;

    /**
     * Messages
     *
     * @return array
     */
    abstract public static function messages(): array;
}
