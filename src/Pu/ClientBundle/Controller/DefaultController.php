<?php

namespace Pu\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PuClientBundle:Default:index.html.twig');
    }
}
