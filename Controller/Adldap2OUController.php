<?php

namespace Adldap2Bundle\Controller;


class Adldap2OUController extends Adldap2Controller {
    /**
     * Get all OUs from Active Directory
     *
     * @return array|\Illuminate\Support\Collection
     * @throws \Exception
     */
    public function getAllOus() {
        $provider = parent::connectAsAdmin();
        $search = $provider->search();
        return $search->ous()->get();
    }



    //TODO: Add create, findbyname, update and delete functions
}
