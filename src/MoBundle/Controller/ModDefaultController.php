<?php

namespace MoBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModDefaultController extends Controller
{
    public function renderAction(Request $request)
    {
        return $this->render('MoBundle:ModDefault:render.html.twig', array(
    		'position'=>$request->get('position'),

        	));
    }

    public function formAction()
    {
        return $this->render('MoBundle:ModDefault:form.html.twig',array('name'=>'MoPicOne'));
    }
}
