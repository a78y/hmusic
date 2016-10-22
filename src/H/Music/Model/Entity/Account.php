<?php

namespace H\Music\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity(
 *     repositoryClass="H\Music\Model\Repository\AccountRepository"
 * )
 * @Table(
 *     name="auth_account",
 *     indexes={
 *         @Index(name="iname", columns={"name"}),
 *         @Index(name="iemail", columns={"email"}),
 *         @Index(name="ienabled", columns={"enabled"}),
 *         @Index(name="icreated_at", columns={"created_at"}),
 *         @Index(name="iupdated_at", columns={"updated_at"})
 *     }
 * )
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class Account extends Entity
{
    /** @Column(name="name", type="string", length=32, unique=true, options={ "default": "" }) */
    protected $name;

    /** @Column(name="email", type="string", length=32, unique=true, options={ "default": "" }) */
    protected $email;

    /** @Column(name="password", type="string", length=32, options={ "default": "" }) */
    protected $password;

    /** @Column(name="enabled", type="smallint", options={ "default": 1 }) */
    protected $enabled;

    /** @Column(name="data", type="json_array") */
    protected $data;

    /** @Column(name="auth_at", type="datetime") */
    protected $authAt;

    /** @Column(name="access_at", type="datetime") */
    protected $accessAt;

    /**
     * @ManyToMany(targetEntity="AccountRole")
     * @JoinTable(
     *   name="auth_account_role",
     *   joinColumns={@JoinColumn(name="aid", referencedColumnName="id")},
     *   inverseJoinColumns={@JoinColumn(name="rid", referencedColumnName="id")}
     * )
     */
    protected $roles;

    /**
     * Entity constructor.
     */
    public function __construct() {
        $this->roles = new ArrayCollection();
    }

    /**
     * Set account name.
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
     * Get account name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set account email.
     *
     * @param string $email
     *
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get account email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set account password.
     *
     * @param string $password
     *
     * @return Account
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get account password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set account enabled status.
     *
     * @param int $enabled
     *
     * @return Account
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get account enabled status.
     *
     * @return int
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set account data
     *
     * @param array $data
     *
     * @return Account
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get account data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set authentication date.
     *
     * @param \DateTime $authAt
     *
     * @return Account
     */
    public function setAuthAt(\DateTime $authAt)
    {
        $this->authAt = $authAt;

        return $this;
    }

    /**
     * Get authentication date.
     *
     * @return \DateTime
     */
    public function getAuthAt()
    {
        return $this->authAt;
    }

    /**
     * Set last access date.
     *
     * @param \DateTime $accessAt
     *
     * @return Account
     */
    public function setAccessAt(\DateTime $accessAt)
    {
        $this->accessAt = $accessAt;

        return $this;
    }

    /**
     * Get last access date.
     *
     * @return \DateTime
     */
    public function getAccessAt()
    {
        return $this->accessAt;
    }

    /**
     * Set account roles.
     *
     * @param ArrayCollection $roles
     *
     * @return Account
     */
    public function setRoles(ArrayCollection $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get account roles.
     *
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Get names of account roles.
     *
     * @return array
     */
    public function getRoleNames()
    {
        $roles = array();

        if ($this->roles)
        {
            foreach ($this->roles as $role)
            {
                if ($role instanceof AccountRole)
                {
                    array_push($roles, $role->getName());
                }
            }
        }

        return $roles;
    }
}
