<?php

namespace H\Music\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * User account provider.
 *
 * @author Yudin Alexey <alexeyvet@gmail.com>
 */
class AccountProvider implements UserProviderInterface
{
    private $repository;
    private $method;

    /**
     * Class constructor.
     *
     * @param EntityRepository $repository
     * @param string           $method
     */
    public function __construct(EntityRepository $repository, $method)
    {
        $this->repository = $repository;
        $this->method = $method;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $account = call_user_func(array($this->repository, $this->method), $username);
        if (!$account) {
            throw new \RuntimeException(sprintf('Account "%s" not found.', $username));
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
