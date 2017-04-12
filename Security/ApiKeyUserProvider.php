<?php

/*
 * (c) Rafał Mikołajun <rafal@mikoweb.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\Bundle\SimpleApiKeyBundle\Security;

use Mikoweb\Bundle\SimpleApiKeyBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Uecode\Bundle\ApiKeyBundle\Security\Authentication\Provider\ApiKeyUserProviderInterface;

/**
 * @author Rafał Mikołajun <rafal@mikoweb.pl>
 * @package mikoweb/simple-api-key-bundle
 */
class ApiKeyUserProvider implements ApiKeyUserProviderInterface, UserProviderInterface
{
    /**
     * @var array
     */
    protected $groups;

    /**
     * @var array
     */
    protected $keys;

    /**
     * @var string
     */
    protected $userClass;

    /**
     * @param array $groups
     * @param array $keys
     * @param string $userClass
     */
    public function __construct(array $groups, array $keys, $userClass)
    {
        $this->groups = $groups;
        $this->keys = $keys;
        $this->userClass = $userClass;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByApiKey($apiKey)
    {
        $user = null;

        if (isset($this->keys[$apiKey]) && isset($this->groups[$this->keys[$apiKey]])) {
            $group = $this->groups[$this->keys[$apiKey]];
            $user = new $this->userClass;
            $user->setEnabled(true);
            $user->setGroupName($this->keys[$apiKey]);
            $user->setApiKey($apiKey);
            $user->setRoles(is_array($group['roles']) ? $group['roles'] : []);
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        throw new \RuntimeException('Unexpected method.');
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return is_subclass_of($class, $this->userClass);
    }
}
