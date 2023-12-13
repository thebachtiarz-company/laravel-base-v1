<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Http\Requests\Rules\Date;

use TheBachtiarz\Base\App\Http\Requests\Rules\AbstractRule;

use function sprintf;

class DateRangeRule extends AbstractRule
{
    public const INPUT_DATEFROM = 'dateFrom';
    public const INPUT_DATETO   = 'dateTo';

    public static function rules(): array
    {
        return [
            self::INPUT_DATEFROM => [
                'nullable',
                'date_format:Y-m-d',
            ],
            self::INPUT_DATETO => [
                'nullable',
                'date_format:Y-m-d',
            ],
        ];
    }

    public static function messages(): array
    {
        return [
            sprintf('%s.date_format', self::INPUT_DATEFROM) => 'Date From format invalid! (valid format: 2024-08-17)',
            sprintf('%s.date_format', self::INPUT_DATETO) => 'Date To format invalid! (valid format: 2024-08-17)',
        ];
    }
}
