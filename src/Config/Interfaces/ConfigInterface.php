<?php

namespace TheBachtiarz\Base\Config\Interfaces;

interface ConfigInterface
{
    /**
     * Model table name
     *
     * @var string
     */
    public const TABLE_NAME = 'thebachtiarz_configs';

    /**
     * Attributes fillable
     */
    public const ATTRIBUTES_FILLABLE = [
        self::ATTRIBUTE_PATH,
        self::ATTRIBUTE_ISENCRYPT,
        self::ATTRIBUTE_VALUE
    ];

    public const ATTRIBUTE_ID = 'id';
    public const ATTRIBUTE_PATH = 'path';
    public const ATTRIBUTE_ISENCRYPT = 'is_encrypt';
    public const ATTRIBUTE_VALUE = 'value';

    // ? Getter Modules
    /**
     * Get id
     *
     * @return integer|null
     */
    public function getId(): ?int;

    /**
     * Get path
     *
     * @return string|null
     */
    public function getPath(): ?string;

    /**
     * Get is encrypt
     *
     * @return boolean|null
     */
    public function getIsEncrypt(): ?bool;

    /**
     * Get value
     *
     * @return mixed
     */
    public function getValue(): mixed;

    // ? Setter Modules
    /**
     * Set id
     *
     * @param integer $id
     * @return self
     */
    public function setId(int $id): self;

    /**
     * Set path
     *
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self;

    /**
     * Set is encrypt
     *
     * @param boolean $isEncrypt
     * @return self
     */
    public function setIsEncrypt(bool $isEncrypt): self;

    /**
     * Set value
     *
     * @param mixed $value
     * @return self
     */
    public function setValue(mixed $value): self;
}
