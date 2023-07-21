<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Http\Requests\Rules;

use TheBachtiarz\Base\App\Http\Requests\Rules\AbstractRule;

use function sprintf;

class ConfigPathRule extends AbstractRule
{
    public const INPUT_PATH = 'path';

    public static function rules(): array
    {
        return [
            self::INPUT_PATH => [
                'required',
                'string',
            ],
        ];
    }

    public static function messages(): array
    {
        return [sprintf('%s.required', self::INPUT_PATH) => 'Path name is required'];
    }
}
