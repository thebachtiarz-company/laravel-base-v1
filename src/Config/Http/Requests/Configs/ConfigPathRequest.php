<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Http\Requests\Configs;

use TheBachtiarz\Base\App\Http\Requests\AbstractRequest;
use TheBachtiarz\Base\Config\Http\Requests\Rules\ConfigPathRule;

class ConfigPathRequest extends AbstractRequest
{
    public function rules(): array
    {
        return ConfigPathRule::rules();
    }

    public function messages()
    {
        return ConfigPathRule::messages();
    }
}
