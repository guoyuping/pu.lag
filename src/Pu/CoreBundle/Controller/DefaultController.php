<?php

namespace Pu\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PuCoreBundle:Default:index.html.twig');
    }
}
