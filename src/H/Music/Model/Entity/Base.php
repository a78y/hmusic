<?php

namespace H\Music\Model\Entity;

/**
 * @MappedSuperclass
 * @HasLifecycleCallbacks
 */
class Base {
    /**
     * @Id
     * @Column(name="id", type="guid")
     * @GeneratedValue(strategy="UUID")
     */
    protected $id;

    /** @Column(type="datetime", name="created_at") */
    protected $createdAt;

    /** @Column(type="datetime", name="updated_at") */
    protected $updatedAt;
    
    /**
    * @Column(type="integer")
    * @Version
    */
    protected $version;
   
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
