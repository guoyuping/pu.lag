<?php

namespace Pu\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PuUserBundle:Default:index.html.twig');
    }
}
