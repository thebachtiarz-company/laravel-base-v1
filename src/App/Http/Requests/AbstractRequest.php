<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use TheBachtiarz\Base\App\Http\Requests\Rules\AbstractRule;

use function array_map;
use function array_merge;
use function assert;

abstract class AbstractRequest extends FormRequest
{
    /**
     * Define rules
     *
     * @var string[]
     */
    protected array $rules = [];

    /**
     * Defined rules for proposed request
     *
     * @var AbstractRule[]
     */
    private array $definedRules = [];

    /**
     * Constructor
     */
    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null,
    ) {
        $this->setRules($this->rules);

        parent::__construct(
            query: $query,
            request: $request,
            attributes: $attributes,
            cookies: $cookies,
            files: $files,
            server: $server,
            content: $content,
        );
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, (ValidationRule|array|string)>
     */
    public function rules(): array
    {
        return array_merge(
            ...array_map(
                callback: static fn (AbstractRule $rule): array => $rule::rules(),
                array: $this->getRules(),
            ),
        );
    }

    /** @inheritDoc */
    public function messages()
    {
        return array_merge(
            ...array_map(
                callback: static fn (AbstractRule $rule): array => $rule::messages(),
                array: $this->getRules(),
            ),
        );
    }

    /**
     * Get the value of defined rules
     */
    public function getRules(): array
    {
        return $this->definedRules;
    }

    /**
     * Set the value of defined rules
     *
     * @see \TheBachtiarz\Base\App\Http\Requests\Rules\AbstractRule
     *
     * @param string[] $rules Each class must be inheritance from AbstractRule.
     */
    public function setRules(array $rules = []): self
    {
        $this->definedRules = array_map(
            callback: static function (string $rule) {
                assert(new $rule() instanceof AbstractRule);

                return new $rule();
            },
            array: $rules,
        );

        return $this;
    }
}
