<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Interfaces;

interface ConfigInterface
{
    /**
     * Model table name
     */
    public const TABLE_NAME = 'thebachtiarz_configs';

    /**
     * Attributes fillable
     */
    public const ATTRIBUTES_FILLABLE = [
        self::ATTRIBUTE_PATH,
        self::ATTRIBUTE_ISENCRYPT,
        self::ATTRIBUTE_VALUE,
    ];

    public const ATTRIBUTE_ID        = 'id';
    public const ATTRIBUTE_PATH      = 'path';
    public const ATTRIBUTE_ISENCRYPT = 'is_encrypt';
    public const ATTRIBUTE_VALUE     = 'value';

    // ? Getter Modules

    /**
     * Get id
     */
    public function getId(): int|null;

    /**
     * Get path
     */
    public function getPath(): string|null;

    /**
     * Get is encrypt
     */
    public function getIsEncrypt(): bool|null;

    /**
     * Get value
     */
    public function getValue(): mixed;

    // ? Setter Modules

    /**
     * Set id
     */
    public function setId(int $id): self;

    /**
     * Set path
     */
    public function setPath(string $path): self;

    /**
     * Set is encrypt
     */
    public function setIsEncrypt(bool $isEncrypt): self;

    /**
     * Set value
     */
    public function setValue(mixed $value): self;
}
