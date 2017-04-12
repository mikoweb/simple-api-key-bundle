<?php

/*
 * (c) Rafał Mikołajun <rafal@mikoweb.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\Bundle\SimpleApiKeyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User entity.
 *
 * @author Rafał Mikołajun <rafal@mikoweb.pl>
 * @package mikoweb/simple-api-key-bundle
 *
 * @ORM\Entity(readOnly=true)
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $groupName;

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->getGroupName() . ':' . $this->getApiKey();
    }
}
