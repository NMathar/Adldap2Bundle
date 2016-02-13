<?php

namespace Adldap2Bundle\Controller;

//use Adldap2Bundle\Controller\Adldap2Controller;

class Adldap2UserController extends Adldap2Controller
{
    public function getAllUsers()
    {
        return $this->ad->users()->all();
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
    public function findUserbyUsername($username, $select = NULL)
    {
        return $this->ad->users()->find($username, $select);
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
        if ($this->ad->users()->create($attributes)) {
            return 'User was successfully created.';
        } else {
//            var_dump($this->ad->getConnection()->showErrors());
            throw new \Exception('User could not be created. Check attributes !  Error: ' .  json_encode($this->ad->getConnection()->err2Str($this->ad->getConnection()->errNo())));
//            return 'User was not created';
        }
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
    public function newUser($firstname, $lastname, $username, $email)
    {
        $user = $this->ad->users()->newInstance();


        $cn = "$lastname, $firstname";


//        $user->setDn($dn);
        $user->setCommonName($cn);
        $user->setName($cn);
        $user->setAccountName($username);
        $user->setFirstName($firstname);
        $user->setLastName($lastname);
//        $user->setTitle($attributes['title']);
//        $user->setDepartment($attributes['department']);
//        $user->setTelephoneNumber($attributes['ipphone']);
//        $user->setCompany($attributes['company']);
        $user->setEmail($email);


        //TODO: Set dn as Democontroller

        $dn = $user->getDnBuilder();

        //TODO: example
        $dn->addCn($user->getCommonName());
        $dn->addOu('Users');
        $dn->addDc('LOCAL');
        $dn->addDc('DOMAIN');
        $dn->addDc('AD');

        $user->setDn($dn);

        if ($user->save()) {
            return $user;
        } else {
//            var_dump($this->ad->getConnection()->showErrors());
            throw new \Exception('User could not be created. Check attributes !  Error: ' .  json_encode($this->ad->getConnection()->err2Str($this->ad->getConnection()->errNo())));
        }
    }
}
