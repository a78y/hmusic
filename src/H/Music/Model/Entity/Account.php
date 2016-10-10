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
 *         @Index(name="istatus", columns={"status"})
 *     },
 *     uniqueConstraints={
 *         @UniqueConstraint(name="iname_email", columns={"name", "email"})
 *     }
 * )
 */
class Account extends Base {    
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
}
