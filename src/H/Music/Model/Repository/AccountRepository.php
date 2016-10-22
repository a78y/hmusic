<?php

namespace H\Music\Model\Repository;

use Doctrine\ORM\EntityRepository;
use H\Music\Model\Entity\Account;

/**
 * Account entity repository.
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class AccountRepository extends EntityRepository {

    /**
     * Get account by name.
     *
     * @param string $name
     *
     * @return Account
     */
    function getByName($name)
    {
        return null;
    }
}
