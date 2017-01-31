<?php

namespace Adldap2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Adldap2ComputerController extends Adldap2Controller
{
    /**
     * Get all Computers from Active Directory
     *
     * @return array|\Illuminate\Support\Collection
     * @throws \Exception
     */
    public function getAllComputers() {
        $provider = parent::connectAsAdmin();
        $search = $provider->search();
        return $search->computers()->get();
    }


    /**
     * find computer by computername
     *
     * @param $computername
     * @param array $select
     * @return mixed
     * @throws \Exception
     */
    public function findComputerbyName($computername) {
        if ($provider = parent::connectAsAdmin()) {
            try {
                $search = $provider->search();
                $result = $search
                    ->where('cn', '=', $computername)
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
     * find computer by dn
     *
     * @param $dn
     * @param array $select
     * @return mixed
     * @throws \Exception
     *
     */
    public function findComputerbyDN($dn) {
        if ($provider = parent::connectAsAdmin()) {
            try {
                $search = $provider->search();
                $result = $search->computers()->findByDn($dn);
                return $result;
            } catch (Adldap\Exceptions\ModelNotFoundException $e) {
                // user wasn't found!
                return FALSE;
            }
        }
        return FALSE;
    }


    /**
     * $attributes = [
     *   'description' => 'New Description',
     * ];
     * @param $attributes
     * @param $computername
     * @return bool
     */
    public function updateComputer($computername, array $attributes) {

        $computer = $this->findComputerbyName($computername);
        if (is_array($attributes)) {
            foreach ($attributes as $attrname => $attrvalue) {
                $computer->setAttribute($attrname, $attrvalue);
            }
            if ($computer->update()) {
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
     * Create an Active Directory computer
     * $attributes = [
     *   'cn' => 'NewComputer',
     * ];
     * @param $attributes
     * @return boolean
     */
    public function createComputer(array $attributes) {
        if ($provider = parent::connectAsAdmin()) {
            $computer = $provider->make()->computer($attributes);
            if ($computer->save()) {
                // Computer was saved.
                return TRUE;
            } else {
                // There was an issue saving this computer.
                return FALSE;
            }
        }
        return FALSE;
    }


    /**
     * @param $computername
     */
    public function deleteComputer($computername) {

        if ($provider = parent::connectAsAdmin()) {
            $computer = $provider->search()->getQuery()->findBy('name', $computername);
            if ($computer->exists) {
                if ($computer->delete()) {
                    // Successfully deleted user.
                    return TRUE; // Returns false.
                }
            }
        }
        return FALSE;
    }
}
