<?php

namespace TheBachtiarz\Base\App\Interfaces\Model;

interface AbstractModelInterface
{
    //

    public const ATTRIBUTE_ID = 'id';
    public const ATTRIBUTE_CREATEDAT = 'created_at';
    public const ATTRIBUTE_UPDATEDAT = 'updated_at';

    // ? Public Methods
    /**
     * Get data.
     *
     * Get by attribute or return whole data.
     *
     * @param string $attribute
     * @return mixed
     */
    public function getData(string $attribute): mixed;

    /**
     * Set data.
     *
     * Set data using attribute and value exist.
     *
     * @param string $attribute
     * @param mixed $value
     * @return static
     */
    public function setData(string $attribute, mixed $value): static;

    // ? Getter Modules
    /**
     * Get id
     *
     * @return integer|null
     */
    public function getId(): ?int;

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    // ? Setter Modules
    /**
     * Set id
     *
     * @param integer $id
     * @return static
     */
    public function setId(int $id): static;

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return static
     */
    public function setCreatedAt($createdAt);

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return static
     */
    public function setUpdatedAt($updatedAt);
}
