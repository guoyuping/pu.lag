<?php

namespace Pu\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Pu\UserBundle\Form\Model\Registration;
use Pu\UserBundle\Form\Type\RegistrationType;

class AccountController extends Controller
{
	public function registerAction(Request $request)
	{
		$form = $this->createForm(RegistrationType::class, new Registration(),[

				'method'=>'post'
			]);
		if ($request->getMethod()=='POST') {
			$dm = $this->get('doctrine_mongodb')->getManager();
			$form->handleRequest($request);	
			if ($form->isValid()) {
				$registration = $form->getData();
				$user = $registration->getUser();
				$encoder = $this->container->get('security.password_encoder');
				$password_encoded = $encoder->encodePassword($user,$user->getPassword());
				$user->setPassword($password_encoded);
				$dm->persist($user);
				$dm->flush();
			}
		}
		return $this->render('PuUserBundle:Account:register.html.twig', array('form' => $form->createView()));
	}
}
