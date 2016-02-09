<?php

namespace Adldap2Bundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Adldap2Controller
{
    protected $config;

    public function __construct($kernel)
    {
        $this->config = $kernel->getContainer()->getParameter('adldap2')['config'];

        //show all config data
        //var_dump($this->config);

        //array(1) {
        //        ["config"]=> array(10) {
        //            ["account_suffix"]=> string(11) "@gatech.edu",
        //            ["domain_controllers"]=> string(21) "whitepages.gatech.edu",
        //            ["port"]=> int(389),
        //            ["base_dn"]=> string(30) "dc=whitepages,dc=gatech,dc=edu",
        //            ["admin_username"]=> string(0) "",
        //            ["admin_password"]=> string(0) "",
        //            ["follow_referrals"]=> bool(true),
        //            ["use_ssl"]=> bool(false),
        //            ["use_tls"]=> bool(false),
        //            ["use_sso"]=> bool(false)
        //        }
        //    }
    }


    public function name($name)
    {
//        $config = $this->container->getParameter('adldap2');
        $config = $this->config['account_suffix'];
        var_dump($config);
        var_dump($name);


        return $name;
    }
}
