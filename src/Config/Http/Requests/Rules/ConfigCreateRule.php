<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Http\Requests\Rules;

use TheBachtiarz\Base\App\Http\Requests\Rules\AbstractRule;

use function array_merge;

class ConfigCreateRule extends AbstractRule
{
    public const INPUT_VALUE     = 'value';
    public const INPUT_ISENCRYPT = 'isEncrypt';

    public static function rules(): array
    {
        return array_merge(
            ConfigPathRule::rules(),
            [
                self::INPUT_VALUE => [
                    'nullable',
                    'string',
                ],
                self::INPUT_ISENCRYPT => [
                    'nullable',
                    'boolean',
                ],
            ],
        );
    }

    public static function messages(): array
    {
        return array_merge(
            ConfigPathRule::messages(),
            [],
        );
    }
}
