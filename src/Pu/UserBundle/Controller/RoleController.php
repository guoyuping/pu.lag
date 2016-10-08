<?php

namespace Pu\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pu\UserBundle\Form\Type\RoleType;
use Pu\UserBundle\Document\Role;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends Controller
{
	public function newAction(Request $request)
	{
		$form = $this->createForm(RoleType::class, new Role());
		if ($request->getMethod()=='POST') {
			$dm = $this->get('doctrine_mongodb')->getManager();
			$form->handleRequest($request);
			if ($form->isValid()) {
				$role = $form->getData();
				$dm->persist($role);
				$dm->flush();
				return $this->redirectToRoute('role_list');
			}
		}
	    return $this->render('PuViewBundle:Admin/User/Role:new.html.twig',['form'=>$form->createView()]);
	}
	public function listAction(Request $request)
	{
		$dm = $this->get('doctrine_mongodb')->getManager();
		$qb = $dm->createQueryBuilder("PuUserBundle:Role");
		$query = $qb->getQuery();
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->get('page',1),
			10);
		return $this->render('PuViewBundle:Admin/User/Role:list.html.twig',['pagination'=>$pagination]);
	}
}
