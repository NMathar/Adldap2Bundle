<?php

namespace Adldap2Bundle\Controller;


class Adldap2ContainerController extends Adldap2Controller
{
    /**
     * Get all Containers from Active Directory
     *
     * @return array|\Illuminate\Support\Collection
     * @throws \Exception
     */
    public function getAllContainers() {
        $provider = parent::connect();
        $search = $provider->search();

        return $search->containers()->get();
    }

    /**
     * return Active Directory Default Containers (Most used folders Users, Computers and Builtin)
     *
     * @return mixed
     * @throws \Exception
     */
    public function getDefaultContainers(){
        $provider = parent::connect();
        $search = $provider->search();

        return $search->orWhereEquals("cn", "Users")->orWhereEquals("cn", "Computers")->orWhereContains('cn', 'Builtin')->get();
    }
}
