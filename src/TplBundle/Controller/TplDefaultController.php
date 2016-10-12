<?php

namespace TplBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TplDefaultController extends Controller
{
    public function renderAction(Request $request)
    {
    	$mods = $request->get('mods');
        return $this->render('TplBundle:TplDefault:render.html.twig',array('mods'=>$mods));
    }
}
