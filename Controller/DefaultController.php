<?php

namespace Adldap2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @param $name
     * @return array
     */
    public function name($name)
    {
        return $this->render('', array('name' => $name));
    }
}
