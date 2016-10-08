<?php

namespace Pu\ModBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PuModBundle:Default:index.html.twig');
    }
}
