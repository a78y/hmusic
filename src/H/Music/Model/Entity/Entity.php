<?php

namespace H\Music\Model\Entity;

/**
 * @MappedSuperclass
 * @HasLifecycleCallbacks
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class Entity
{
    /**
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /** @Column(type="datetime", name="created_at") */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") */
    protected $updatedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created date
     *
     * @param \DateTime $createdAt
     *
     * @return Entity
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get created date
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updated date
     *
     * @param \DateTime $updatedAt
     *
     * @return Entity
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updated date
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /** @PrePersist */
    public function onPrePersist()
    {
        $this->createdAt = $this->updatedAt = date('Y-m-d H:i:s');
    }

    /** @PreUpdate */
    public function onPreUpdate()
    {
        $this->updatedAt = date('Y-m-d H:i:s');
    }
}
