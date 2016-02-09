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

        //get configuration
        $this->container->getParameter('account_suffix');
    }
}

?>