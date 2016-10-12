<?php

namespace MoBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModPicOneController extends Controller
{
    public function renderAction(Request $request)
    {

        return $this->render('MoBundle:ModPicOne:render.html.twig', array(
    		'position'=>$request->get('position'),
            'param'=>$request->get('param')
        	));
    }

    public function formAction(Request $request)
    {
        return $this->render('MoBundle:ModPicOne:form.html.twig',array(
            'param'=>$request->get('param')
            ));
    }
}
