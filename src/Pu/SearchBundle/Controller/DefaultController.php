<?php

namespace Pu\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PuSearchBundle:Default:index.html.twig');
    }
}
