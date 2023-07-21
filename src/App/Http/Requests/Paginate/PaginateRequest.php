<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Http\Requests\Paginate;

use TheBachtiarz\Base\App\Http\Requests\AbstractRequest;
use TheBachtiarz\Base\App\Http\Requests\Rules\PaginateRule;

class PaginateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return PaginateRule::rules();
    }

    public function messages()
    {
        return PaginateRule::messages();
    }
}
