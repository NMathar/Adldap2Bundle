<?php

namespace Adldap2Bundle\Controller;

use \Adldap\Adldap;

class Adldap2Controller
{
    protected $config;
    protected $ad;

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
        //            ["admin_username"]=> string(0) "username",
        //            ["admin_password"]=> string(0) "password",
        //            ["follow_referrals"]=> bool(true),
        //            ["use_ssl"]=> bool(false),
        //            ["use_tls"]=> bool(false),
        //            ["use_sso"]=> bool(false)
        //        }
        //    }

//        var_dump($this->config);
        $this->ad = new Adldap($this->config);
    }


    public function authentication($username, $password)
    {
        if ($this->ad->authenticate($username, $password)) {
            // User passed authentication
            var_dump("login success");
        } else {
            // Uh oh, looks like the username or password is incorrect
            var_dump("login error");
        }
    }

    public function connect($username, $password)
    {
        if ($this->ad->connect($username, $password)) {
            // User passed authentication
            var_dump("connect success");
            return $this->ad;
        } else {
            // Uh oh, looks like the username or password is incorrect
            var_dump("connect error");
            return NULL;
        }
    }

    public function parseLdapDn($dn)
    {
        $parsr = ldap_explode_dn($dn, 0);
        $out = array();
        foreach ($parsr as $key => $value) {
            if (FALSE !== strstr($value, '=')) {
                list($prefix, $data) = explode("=", $value);
                $data = preg_replace("/\\\([0-9A-Fa-f]{2})/e", "''.chr(hexdec('\\1')).''", $data);
                if (isset($current_prefix) && $prefix == $current_prefix) {
                    $out[$prefix][] = $data;
                } else {
                    $current_prefix = $prefix;
                    $out[$prefix][] = $data;
                }
            }
        }
        return $out;
    }

}
