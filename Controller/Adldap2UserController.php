<?php

namespace Adldap2Bundle\Controller;


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
        if ($provider = parent::connectAsAdmin()) {
            try {
                $search = $provider->search();
                $result = $search
                    ->where('samaccountname', '=', $username)
                    ->select($select)
                    ->first();
                return $result;
            } catch (Adldap\Exceptions\ModelNotFoundException $e) {
                // user wasn't found!
                return FALSE;
            }
        }
        return FALSE;
    }

    /**
     * find user by dn
     *
     * @param $dn
     * @param array $select
     * @return mixed
     * @throws \Exception
     *
     */
    public function findUserbyDN($dn) {
        if ($provider = parent::connectAsAdmin()) {
            try {
                $search = $provider->search();
                $result = $search->users()->findByDn($dn);
                return $result;
            } catch (Adldap\Exceptions\ModelNotFoundException $e) {
                // user wasn't found!
                return FALSE;
            }
        }
        return FALSE;
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
        if ($provider = parent::connectAsAdmin()) {
            $user = $provider->make()->user($attributes);
            if ($user->save()) {
                // User was saved.
                return TRUE;
            } else {
                // There was an issue saving this user.
                return FALSE;
            }
        }
        return FALSE;
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

        if ($provider = parent::connectAsAdmin()) {
            $user = $provider->search()->getQuery()->findBy('samaccountname', $username);
            if ($user->exists) {
                if ($user->delete()) {
                    // Successfully deleted user.
                    return TRUE; // Returns false.
                }
            }
        }
        return FALSE;
    }
}
