<?php

namespace Adldap2Bundle\Controller;


class Adldap2GroupController extends Adldap2Controller
{
    /**
     * Get all Groups from Active Directory
     *
     * @return array|\Illuminate\Support\Collection
     * @throws \Exception
     */
    public function getAllGroups() {
        $provider = parent::connectAsAdmin();
        $search = $provider->search();
        return $search->groups()->get();
    }

    /**
     * find group by groupname
     *
     * @param $username
     * @param array $select
     * @return mixed
     * @throws \Exception
     */
    public function findGroupbyName($groupname) {
        if ($provider = parent::connectAsAdmin()) {
            try {
                $search = $provider->search();
                $result = $search
                    ->where('cn', '=', $groupname)
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
     * find group by dn
     *
     * @param $dn
     * @param array $select
     * @return mixed
     * @throws \Exception
     *
     */
    public function findGroupbyDN($dn) {
        if ($provider = parent::connectAsAdmin()) {
            try {
                $search = $provider->search();
                $result = $search->groups()->findByDn($dn);
                return $result;
            } catch (Adldap\Exceptions\ModelNotFoundException $e) {
                // user wasn't found!
                return FALSE;
            }
        }
        return FALSE;
    }


    /**
     * Create an Active Directory group
     * $attributes = [
     *   'cn' => 'NewGroup',
     * ];
     * @param $attributes
     * @return boolean
     */
    public function createGroup(array $attributes) {
        if ($provider = parent::connectAsAdmin()) {
            $group = $provider->make()->group($attributes);
            if ($group->save()) {
                // Group was saved.
                return TRUE;
            } else {
                // There was an issue saving this group.
                return FALSE;
            }
        }
        return FALSE;
    }


    /**
     * @param $groupname
     */
    public function deleteGroup($groupname) {

        if ($provider = parent::connectAsAdmin()) {
            $group = $provider->search()->getQuery()->findBy('name', $groupname);
            if ($group->exists) {
                if ($group->delete()) {
                    // Successfully deleted user.
                    return TRUE; // Returns false.
                }
            }
        }
        return FALSE;
    }

    //TODO: Add delete functions
    
    

}
