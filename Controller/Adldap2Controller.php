<?php

namespace Adldap2Bundle\Controller;

use \Adldap\Adldap;
use Adldap\Connections\Provider;

class Adldap2Controller
{
    protected $config;
    protected $ad;
    protected $provider;

    public function __construct($kernel)
    {
        $this->config = $kernel->getContainer()->getParameter('adldap2')['config'];

        //show all config data
        //var_dump($this->config);

        $this->ad = new Adldap();
        $this->provider = new Provider($this->config);
        $this->ad->addProvider('default', $this->provider);
    }


    public function authentication($username, $password)
    {
        try {

            if ($this->provider->auth()->attempt($username, $password)) {
                // Credentials were correct.
                var_dump("login success");
            } else {
                // Credentials were incorrect.
                var_dump("login failed: Credentials were incorrect");
            }

        } catch (\Adldap\Exceptions\Auth\UsernameRequiredException $e) {
            // The user didn't supply a username.
        } catch (\Adldap\Exceptions\Auth\PasswordRequiredException $e) {
            // The user didn't supply a password.
        }
    }

    protected function connectAsAdmin(){
        try {
            $this->ad->connect('default');
            $this->provider->auth()->bindAsAdministrator();
            return $this->provider;

            // Successfully bound to server.
        } catch (\Adldap\Exceptions\Auth\BindException $e) {
            // There was an issue binding to the LDAP server.
            throw new \Exception('Could not bind as Admin !  Error: ' .  $e);
        }
    }


    public function connect()
    {
        try {
            $this->ad->connect('default');
            // Connection was successful.
            // We can now perform operations on the connection.
            return $this->provider;

        } catch (\Adldap\Exceptions\Auth\BindException $e) {
            throw new \Exception('Can\'t bind to LDAP server!');
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
