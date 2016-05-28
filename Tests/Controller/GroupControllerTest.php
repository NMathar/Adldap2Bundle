<?php

namespace Adldap2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DefaultControllerTest extends WebTestCase
{
    protected $adldap;
    protected $adldapGroup;
    protected $config;
    protected $unitTestGroup = "unittestGroup";

    public function setUp()
    {
        self::bootKernel();
        $this->adldapGroup = static::$kernel->getContainer()->get('adldap2group');
        $this->adldap = static::$kernel->getContainer()->get('adldap2');
        $this->config = static::$kernel->getContainer()->getParameter('adldap2')['config'];
    }


    public function testCreateGroup()
    {
        $attr = array('cn'             => $this->unitTestGroup,
                      'description'           => 'Test description');
        var_dump($this->adldapGroup->createGroup($attr));
    }


    public function testGetGroupInfo()
    {
        $user = $this->adldapGroup->findGroupbyName($this->unitTestGroup);
        var_dump($user->getAccountName());
    }


    public function testGroupDelete()
    {
        if ($this->adldapGroup->deleteGroup($this->unitTestGroup)) {
            var_dump("Group was successful deleted");
        }
    }


}
