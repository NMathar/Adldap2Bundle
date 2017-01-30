<?php

namespace Adldap2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class UserControllerTest extends WebTestCase
{
    protected $adldap;
    protected $adldapUser;
    protected $config;
    protected $unitTestUser = "unittest";
    protected $unitTestUserPassword = "Pw123__!";

    public function setUp()
    {
        self::bootKernel();
        $this->adldapUser = static::$kernel->getContainer()->get('adldap2user');
        $this->adldap = static::$kernel->getContainer()->get('adldap2');
        $this->config = static::$kernel->getContainer()->getParameter('adldap2')['config'];
    }


    public function testCreateUser()
    {
        $attr = array(
            'cn' => $this->unitTestUser,
            'dn' => "cn=" . $this->unitTestUser . "," . $this->config['base_dn'],
            'sn' => 'Symfony',
            'samaccountname' => $this->unitTestUser,
            'mail' => 'test@mail.com');

        var_dump($this->adldapUser->createUser($attr, $this->unitTestUserPassword));
    }


    public function testGetUserInfo()
    {
        $user = $this->adldapUser->findUserbyUsername($this->unitTestUser, ['mail']);
        var_dump($user->getAccountName());
    }


    public function testUserEdit()
    {
        var_dump($this->adldapUser->updateUser($this->unitTestUser, array("mail" => "test2@mail.com")));
    }


    public function testUserDelete()
    {
        if ($this->adldapUser->deleteUser($this->unitTestUser)) {
            var_dump("User was successful deleted");
        }
    }


}
