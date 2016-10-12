<?php

namespace Modset\MoPicOneBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModController extends Controller
{
    public function renderAction(Request $request)
    {
    	$position = $request->get('position');
        return $this->render('ModsetMoPicOneBundle::render.html.twig', array(
    		'position'=>$position,

        	));
    }

    public function formAction()
    {

        return $this->render('ModsetMoPicOneBundle::form.html.twig',array('name'=>'MoPicOne'));
    }
}
