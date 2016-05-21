<?php

namespace Adldap2Bundle\Controller;

//use Adldap2Bundle\Controller\Adldap2Controller;

class Adldap2UserController extends Adldap2Controller {

    /**
     * Get all users from Active Directory
     *
     * @return array|\Illuminate\Support\Collection
     * @throws \Exception
     */
    public function getAllUsers() {
        $provider = parent::connect();
        $search = $provider->search();
        return $search->users()->get();
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
     * @param $username
     * @param array $select
     * @return mixed
     * @throws \Exception
     */
    public function findUserbyUsername($username, array $select = array()) {
        parent::connect();
        $provider = parent::authAsAdmin();

        try {
            $search = $provider->search();
            $result = $search
                ->where('samaccountname', '=', $username)
                ->select($select)
                ->first();
            return $result;
        } catch (Adldap\Exceptions\ModelNotFoundException $e) {
            // Record wasn't found!
            return false;
        }
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
    public function createUser(array $attributes) {
        parent::connect();
        $provider = parent::authAsAdmin();

        $user = $provider->make()->user($attributes);
        if ($user->save()) {
            // User was saved.
            return TRUE;
        } else {
            // There was an issue saving this user.
            return FALSE;
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
     * $attributes = [
     *   'givenname' => 'John',
     *   'surname' => 'Doe',
     *   'mail' => 'test@test.com'
     * ];
     * @param $attributes
     * @param $username
     * @return bool
     */
    public function updateUser($username, array $attributes) {

        $user = $this->findUserbyUsername($username);
        if (is_array($attributes)) {
            foreach ($attributes as $attrname => $attrvalue) {
                $user->setAttribute($attrname, $attrvalue);
            }
            if ($user->update()) {
                // User was updated.
                return TRUE;
            } else {
                // There was an issue updating this user.
                return FALSE;
            }
        }
        return FALSE;
    }

    /**
     * @param $username
     */
    public function deleteUser($username) {

        parent::connect();
        $provider = parent::authAsAdmin();
        $user = $provider->search()->getQuery()->findBy('samaccountname', $username);

        if ($user->exists) {
            if ($user->delete()) {
                // Successfully deleted user.
                return TRUE; // Returns false.
            }
        }

        return FALSE;
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
