<?php

namespace H\Music\Model\Entity;

/**
 * @Entity(
 *     repositoryClass="H\Music\Model\Repository\BandRepository"
 * )
 * @Table(
 *     name="band",
 *     indexes={
 *         @Index(name="iname", columns={"name"}),
 *         @Index(name="icreated_at", columns={"created_at"}),
 *         @Index(name="iupdated_at", columns={"updated_at"})
 *     }
 * )
 */
class Band extends Entity {    
    /** @Column(type="string", length=128, options={ "default": "" }) */
    protected $name;

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
}
