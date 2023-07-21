<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Http\Requests\Configs;

use TheBachtiarz\Base\App\Http\Requests\AbstractRequest;
use TheBachtiarz\Base\Config\Http\Requests\Rules\ConfigCreateRule;

class ConfigCreateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return ConfigCreateRule::rules();
    }

    public function messages()
    {
        return ConfigCreateRule::messages();
    }
}
