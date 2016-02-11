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
     * Create a Active Directory user
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
            throw new \Exception('User could not be created. Check attributes!');
        }
    }


    public function newUser($firstname, $lastname, $username, $password)
    {
        $user = $this->ad->users()->newInstance();

        $user->setFirstName($firstname);

        $user->setLastName($lastname);

        $user->setAccountName($username);

        $user->setPassword($password);

        if ($user->save()) {
            return 'User was successfully created.';
        } else {
            throw new \Exception('User could not be created. Check attributes!');
        }
    }
}
