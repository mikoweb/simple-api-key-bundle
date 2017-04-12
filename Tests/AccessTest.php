<?php

namespace Mikoweb\Bundle\SimpleApiKeyBundle\Tests;

/**
 * @author Rafał Mikołajun <rafal@mikoweb.pl>
 * @package mikoweb/simple-api-key-bundle
 */
class AccessTest extends WebTestCaseAbstract
{
    public function testNoApiKey()
    {
        $this->doRequest($this->getRouter()->generate('simple_api_key_index'), 'GET');
        $this->assertEquals(401, $this->getClient()->getResponse()->getStatusCode());

        $this->doRequest($this->getRouter()->generate('simple_api_key_something'), 'GET');
        $this->assertEquals(401, $this->getClient()->getResponse()->getStatusCode());
    }

    public function testInvalidApiKey()
    {
        $this->doRequest($this->getRouter()->generate('simple_api_key_index'), 'GET',
            'invalid');
        $this->assertEquals(403, $this->getClient()->getResponse()->getStatusCode());

        $this->doRequest($this->getRouter()->generate('simple_api_key_something'), 'GET',
            'invalid');
        $this->assertEquals(403, $this->getClient()->getResponse()->getStatusCode());
    }

    public function testValidApiKey()
    {
        $this->doRequest($this->getRouter()->generate('simple_api_key_index'), 'GET',
            'normal_key');
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());

        $this->doRequest($this->getRouter()->generate('simple_api_key_something'), 'GET',
            'normal_key');
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
    }

    public function testGroups()
    {
        $this->doRequest($this->getRouter()->generate('simple_api_key_index'), 'GET',
            'normal_key');
        $this->assertEquals('api_user',
            $this->getClientTokenStorage()->getToken()->getUser()->getGroupName());

        $this->doRequest($this->getRouter()->generate('simple_api_key_index'), 'GET',
            'extended_key');
        $this->assertEquals('api_extended_user',
            $this->getClientTokenStorage()->getToken()->getUser()->getGroupName());
    }

    public function testNormalUserRoles()
    {
        $this->doRequest($this->getRouter()->generate('simple_api_key_index'), 'GET',
            'normal_key');
        $this->assertTrue($this->getClientAuthorizationChecker()->isGranted('ROLE_USER'));
        $this->assertTrue($this->getClientAuthorizationChecker()->isGranted('ROLE_API_USER'));
        $this->assertTrue($this->getClientAuthorizationChecker()->isGranted('ROLE_DO_SOMETHING'));
        $this->assertTrue($this->getClientAuthorizationChecker()->isGranted('ROLE_ACCESS_TO_ARTICLES'));
        $this->assertFalse($this->getClientAuthorizationChecker()->isGranted('ROLE_EXTENDED_ACCESS'));
    }

    public function testExtendedUserRoles()
    {
        $this->doRequest($this->getRouter()->generate('simple_api_key_index'), 'GET',
            'extended_key');
        $this->assertTrue($this->getClientAuthorizationChecker()->isGranted('ROLE_USER'));
        $this->assertTrue($this->getClientAuthorizationChecker()->isGranted('ROLE_API_USER'));
        $this->assertTrue($this->getClientAuthorizationChecker()->isGranted('ROLE_DO_SOMETHING'));
        $this->assertTrue($this->getClientAuthorizationChecker()->isGranted('ROLE_ACCESS_TO_ARTICLES'));
        $this->assertTrue($this->getClientAuthorizationChecker()->isGranted('ROLE_EXTENDED_ACCESS'));
    }

    public function testExtendedAccess()
    {
        $this->doRequest($this->getRouter()->generate('simple_api_key_extended'), 'GET',
            'normal_key');
        $this->assertEquals(403, $this->getClient()->getResponse()->getStatusCode());
        $this->doRequest($this->getRouter()->generate('simple_api_key_extended'), 'GET',
            'extended_key');
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
    }

    /**
     * @param string $path
     * @param string $method
     * @param string|null $apiKey
     */
    protected function doRequest($path, $method, $apiKey = null)
    {
        if (is_null($apiKey)) {
            $this->getClient()->request($method, $path);
        } else {
            $this->getClient()->request($method, $path, [], [], ['HTTP_X_API_KEY' => $apiKey]);
        }
    }
}
