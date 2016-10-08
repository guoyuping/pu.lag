<?php

namespace Pu\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PuPageBundle:Default:index.html.twig');
    }
}
