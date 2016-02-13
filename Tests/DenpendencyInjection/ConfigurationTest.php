<?php
namespace Adldap2Bundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConfigurationTest extends KernelTestCase
{
    private $container;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();


    }

    public function testConfig(){
        //get configuration
        var_dump($this->container->getParameter('adldap2')['config']);
    }
}

?>