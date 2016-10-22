<?php

namespace H\Music\Model\Entity;

/**
 * @Entity()
 * @Table(
 *     name="auth_role",
 *     indexes={
 *         @Index(name="icreated_at", columns={"created_at"}),
 *         @Index(name="iupdated_at", columns={"updated_at"})
 *     }
 * )
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class AccountRole extends Entity
{
    /** @Column(name="name", type="string", length=32, unique=true, options={ "default": "" }) */
    protected $name;

    /** @Column(name="title", type="string", length=128, options={ "default": "" }) */
    protected $title;

    /** @Column(name="permissions", type="json_array") */
    protected $permissions;

    /**
     * Set role name.
     *
     * @param string $name
     *
     * @return Account
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get role name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set role title.
     *
     * @param string $title
     *
     * @return Account
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get role title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set role permissions.
     *
     * @param array $permissions
     *
     * @return Account
     */
    public function setPermissions(array $permissions)
    {
        $this->title = $permissions;

        return $this;
    }

    /**
     * Get role permissions.
     *
     * @return array
     */
    public function getPermissions()
    {
        return $this->title;
    }
}
