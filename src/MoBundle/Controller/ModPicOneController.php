<?php

namespace MoBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModPicOneController extends Controller
{
    public function renderAction($params = null)
    {
        return $this->render('MoBundle:ModPicOne:render.html.twig', array(
            'params'=>$params
        	));
    }

    public function formAction($params = null)
    {
        return $this->render('MoBundle:ModPicOne:form.html.twig',array(
            'params'=>$params
            ));
    }
}
