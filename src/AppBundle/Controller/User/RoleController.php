<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\RoleType;
use AppBundle\Document\Role;
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
	    return $this->render('User/role_new.html.twig',['form'=>$form->createView()]);
	}
	public function listAction(Request $request)
	{
		$dm = $this->get('doctrine_mongodb')->getManager();
		$qb = $dm->createQueryBuilder("AppBundle:Role");
		$query = $qb->getQuery();
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->get('page',1),
			10);
		return $this->render('User/role_list.html.twig',['pagination'=>$pagination]);
	}
}
