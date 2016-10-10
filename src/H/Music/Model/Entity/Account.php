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
class Account extends Entity {    
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
    
    /** @Column(type="datetime", name="logined_at") */
    protected $loginedAt;

    /** @Column(type="datetime", name="accessed_at") */
    protected $accessedAt;

    /**
     * Get id
     *
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
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
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password (plain)
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
     * Set password (hash)
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
     * Get password
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set status
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
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set data
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
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set loginedAt
     *
     * @param \DateTime $loginedAt
     *
     * @return Account
     */
    public function setLoginedAt(\DateTime $loginedAt)
    {
        $this->loginedAt = $loginedAt;

        return $this;
    }

    /**
     * Get loginedAt
     *
     * @return \DateTime
     */
    public function getLoginedAt()
    {
        return $this->loginedAt;
    }

    /**
     * Set accessedAt
     *
     * @param \DateTime $accessedAt
     *
     * @return Account
     */
    public function setAccessedAt(\DateTime $accessedAt)
    {
        $this->accessedAt = $accessedAt;

        return $this;
    }

    /**
     * Get accessedAt
     *
     * @return \DateTime
     */
    public function getAccessedAt()
    {
        return $this->accessedAt;
    }
}
