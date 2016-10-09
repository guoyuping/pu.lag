<?php

namespace Pu\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
	public function homeAction(Request $request)
	{
		return $this->render('PuViewBundle:Admin/Homepage:home.html.twig');

	}
}
