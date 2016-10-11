<?php

namespace H\Music\Model\Entity;

/**
 * @Entity(
 *     repositoryClass="H\Music\Model\Repository\AccountRepository"
 * )
 * @Table(
 *     name="account",
 *     indexes={
 *         @Index(name="iname", columns={"name"}),
 *         @Index(name="iemail", columns={"email"}),
 *         @Index(name="istatus", columns={"status"}),
 *         @Index(name="icreated_at", columns={"created_at"}),
 *         @Index(name="iupdated_at", columns={"updated_at"})
 *     }
 * )
 */
class Account extends Entity
{
    /** @Column(type="string", length=64, unique=true, options={ "default": "" }) */
    protected $name;

    /** @Column(type="string", length=64, unique=true, options={ "default": "" }) */
    protected $email;

    /** @Column(type="string", length=64, options={ "default": "" }) */
    protected $pass;

    /** @Column(type="smallint", options={ "default": 1 }) */
    protected $status;

    /** @Column(type="json_array") */
    protected $data;

    /** @Column(type="datetime", name="auth_at") */
    protected $authAt;

    /** @Column(type="datetime", name="access_at") */
    protected $accessAt;

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
     * Set account password
     *
     * @param string $password
     *
     * @return Account
     */
    public function setPassword($password)
    {
        $this->pass = md5($password);

        return $this;
    }

    /**
     * Set account password hash
     *
     * @param string $pass
     *
     * @return Account
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get account password
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set account status
     *
     * @param int $status
     *
     * @return Account
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get account status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
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
}
