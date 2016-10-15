<?php

namespace TplBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TplDefaultController extends Controller
{
    public function renderAction($params)
    {

        return $this->render('TplBundle:TplDefault:render.html.twig',array(
         	'params'=>$params, //接收所有模块controller名（去重），用于生成form代码
        	//'mixs'=>$request->get('mixs') //接收所有mixed type的子模块（去重），用于生成render代码
        	));
    }
}
