<?php

namespace Adldap2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DefaultControllerTest extends WebTestCase
{
    protected $adldap;
    protected $adldapUser;
    protected $unitTestUser = "unittest";

    public function setUp()
    {
        self::bootKernel();
        $this->adldapUser = static::$kernel->getContainer()->get('adldap2user');
        $this->adldap = static::$kernel->getContainer()->get('adldap2');
    }


    public function testCreateUser()
    {
        var_dump($this->adldapUser->newUser("Test", "Symfony", $this->unitTestUser, "test@mail.com"));
    }


    public function testGetUserInfo()
    {
        $user = $this->adldapUser->findUserbyUsername($this->unitTestUser, null);
        return $user->getFirstName();
    }


    public function testUserDelete()
    {
        if ($user = $this->adldapUser->findUserbyUsername($this->unitTestUser)) {
            var_dump($user->delete());
        }
    }


    //TODO: Build tests for user info, create, edit and delete
}
