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
}
