<?php

namespace Pu\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PuApiBundle:Default:index.html.twig');
    }
}
