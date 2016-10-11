<?php

namespace Modset\MoPicOneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModController extends Controller
{
    public function renderAction()
    {
        return $this->render('ModsetMoPicOneBundle::render.html.twig');
    }

    public function formAction()
    {
        return $this->render('ModsetMoPicOneBundle::form.html.twig',array('name'=>'MoPicOne'));
    }
}
