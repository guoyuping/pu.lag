<?php

namespace Pu\TagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PuTagBundle:Default:index.html.twig');
    }
}
