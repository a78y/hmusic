<?php

namespace H\Music\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use H\Music\Model\Repository\AccountRepository;

/**
 * User account provider.
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class AccountProvider implements UserProviderInterface
{
    private $repository;

    /**
     * Class constructor.
     *
     * @param AccountRepository $repository
     */
    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $account = $this->repository->getByName($username);

        if (!$account) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        return new User($account->getName(), $account->getPassword(), $account->getRoleNames(), $account->getEnabled());
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}
