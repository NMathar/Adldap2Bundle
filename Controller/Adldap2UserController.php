<?php

namespace Adldap2Bundle\Controller;

//use Adldap2Bundle\Controller\Adldap2Controller;

class Adldap2UserController extends Adldap2Controller
{

    public function getAllUsers()
    {
        $provider = parent::connect();
        $search = $provider->search();
        return $search->all();
    }

    /**
     * find user by username
     *
     * limit to speciel fileds with $select
     * $select = [
     *   'cn',
     *   'memberof'
     *   ];
     *
     * @param $name
     */
    public function findUserbyUsername($username, $select = '')
    {
        $provider = parent::connect();
        $search = $provider->search();
        return $search->getQuery()->findBy('samaccountname', $username);
    }


    /**
     * Create an Active Directory user
     * $attributes = [
     *   'cn' => 'John Doe',
     *   'givenname' => 'John',
     *   'surname' => 'Doe',
     * ];
     * @param $attributes
     * @return string
     */
    public function createUser($attributes)
    {
        parent::connect();
        $provider = parent::authAsAdmin();

        $user = $provider->make()->user($attributes);
        if ($user->save()) {
            // User was saved.
            return true;
        } else {
            // There was an issue saving this user.
            return false;
        }
//        $con = $this->connect($this->config['admin_username'], $this->config['admin_password']);
//        if ($con->users()->create($attributes)) {
//            return 'User was successfully created.';
//        } else {
////            var_dump($this->ad->getConnection()->showErrors());
//            throw new \Exception('User could not be created. Check attributes !  Error: ' .  json_encode($this->ad->getConnection()->err2Str($this->ad->getConnection()->errNo())));
////            return 'User was not created';
//        }
    }

    /**
     * @param $username
     */
    public function deleteUser($username){

        parent::connect();
        $provider = parent::authAsAdmin();
        $user = $provider->search()->getQuery()->findBy('samaccountname', $username);

        if($user->exists){
            if ($user->delete()) {
                // Successfully deleted user.
                return true; // Returns false.
            }
        }

        return false;

    }


    /**
     * Not working jet
     *
     * @param $firstname
     * @param $lastname
     * @param $username
     * @param $password
     * @return string
     * @throws \Adldap\Exceptions\AdldapException
     * @throws \Exception
     */
//    public function newUser($firstname, $lastname, $username, $email)
//    {
//        $con = parent::connect($this->config['admin_username'], $this->config['admin_password']);
//
//        $user = $con->users()->newInstance();
//
//        $cn = $username;
//
//        $user->setCommonName($cn);
//        $user->setName($cn);
//        $user->setAccountName($username);
//        $user->setFirstName($firstname);
//        $user->setLastName($lastname);
////        $user->setTitle($attributes['title']);
////        $user->setDepartment($attributes['department']);
////        $user->setTelephoneNumber($attributes['ipphone']);
////        $user->setCompany($attributes['company']);
//
////        $user->setEmail($email);
//
//
//        //build DN
//        $dn = $user->getDnBuilder();
//
//        $baseDNArray = $this->parseLdapDn($this->ad->getConfiguration()->getBaseDn());
//
//        $dn->addCn($user->getCommonName());
//
//        if(isset($baseDNArray['ou']) && count($baseDNArray['ou']) > 0){
//            krsort($baseDNArray['ou']);
//            foreach ($baseDNArray['ou'] as $ou){
//                $dn->addOu($ou);
//            }
//        }
//
//        if(isset($baseDNArray['dc']) &&count($baseDNArray['dc']) > 0 ){
//            krsort($baseDNArray['dc']);
//            foreach ($baseDNArray['dc'] as $dc){
//                $dn->addDc($dc);
//            }
//        }
//        $dn->assemble();
//        $user->setDn($dn);
//
//
//        if ($user->save()) {
//            return $user->getAttributes();
//        } else {
////            var_dump($this->ad->getConnection()->showErrors());
//            throw new \Exception('User could not be created. Check attributes !  Error: ' .  json_encode($this->ad->getConnection()->err2Str($this->ad->getConnection()->errNo())));
//        }
//    }
}
