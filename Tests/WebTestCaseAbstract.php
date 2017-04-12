<?php

namespace Mikoweb\Bundle\SimpleApiKeyBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * @author Rafał Mikołajun <rafal@mikoweb.pl>
 * @package mikoweb/simple-api-key-bundle
 */
abstract class WebTestCaseAbstract extends WebTestCase implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Client
     */
    protected $client;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * @return RouterInterface
     */
    protected function getRouter()
    {
        return $this->container->get('router');
    }

    /**
     * @return AuthorizationChecker
     */
    protected function getClientAuthorizationChecker()
    {
        return $this->getClient()->getContainer()->get('security.authorization_checker');
    }

    /**
     * @return TokenStorage
     */
    protected function getClientTokenStorage()
    {
        return $this->getClient()->getContainer()->get('security.token_storage');
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();
        $this->client = static::createClient();
        $this->setContainer(static::$kernel->getContainer());
    }
}
