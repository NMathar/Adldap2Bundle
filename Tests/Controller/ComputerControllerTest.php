<?php

namespace Adldap2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ComputerControllerTest extends WebTestCase
{
    protected $adldap;
    protected $adldapComputer;
    protected $config;
    protected $unitTestComputer = "unittestComputer";

    public function setUp()
    {
        self::bootKernel();
        $this->adldapComputer = static::$kernel->getContainer()->get('adldap2computer');
        $this->adldap = static::$kernel->getContainer()->get('adldap2');
        $this->config = static::$kernel->getContainer()->getParameter('adldap2')['config'];
    }


    public function testCreateComputer()
    {
        $attr = array(
            'cn' => $this->unitTestComputer,
            'description' => 'Test computer description',
//            'dn' => "cn=" . $this->unitTestComputer . ", OU=Computer, " . $this->config['base_dn'] //TODO: need to test activated computers with right OU path
        );
        var_dump($this->adldapComputer->createComputer($attr));
    }

    public function testUpdateComputer()
    {
        if($this->adldapComputer->updateComputer($this->unitTestComputer, ['description' => 'Test new Description'])){
            var_dump("Computer has been updated successfully.");
        }else{
            var_dump("Update Failed");
        }
    }


    public function testGetComputerInfo()
    {
        $computer = $this->adldapComputer->findComputerbyName($this->unitTestComputer);
        var_dump($computer->getCommonName());
        var_dump($computer->getDN());
    }


    public function testComputerDelete()
    {
        if ($this->adldapComputer->deleteComputer($this->unitTestComputer)) {
            var_dump("Computer has been deleted successfully.");
        }else{
            var_dump("Delte failed");
        }
    }


}
