<?php

namespace Adldap2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DefaultControllerTest extends WebTestCase
{
    protected $adldap;
    protected $adldapUser;
    protected $config;
    protected $unitTestUser = "unittest";

    public function setUp()
    {
        self::bootKernel();
        $this->adldapUser = static::$kernel->getContainer()->get('adldap2user');
        $this->adldap = static::$kernel->getContainer()->get('adldap2');
        $this->config = static::$kernel->getContainer()->getParameter('adldap2')['config'];
    }


    public function testCreateUser()
    {
        $attr = array('cn'             => "Test",
                      'dn'             => "cn=Test,".$this->config['base_dn'],
                      'sn'             => 'Symfony',
                      'samaccountname' => $this->unitTestUser,
                      'mail'           => 'test@mail.com');
        var_dump($this->adldapUser->createUser($attr));
    }


    public function testGetUserInfo()
    {
        $user = $this->adldapUser->findUserbyUsername($this->unitTestUser, null);
        var_dump($user->getAccountName());
    }


    public function testUserDelete()
    {
        if ($this->adldapUser->deleteUser($this->unitTestUser)) {
            var_dump("User Erfolgreich gelöscht");
        }
    }


    //TODO: Build tests for user info, create, edit and delete
}
