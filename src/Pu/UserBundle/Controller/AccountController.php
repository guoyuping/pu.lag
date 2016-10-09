<?php

namespace Pu\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Pu\UserBundle\Form\Model\Registration;
use Pu\UserBundle\Form\Type\RegistrationType;
use Pu\UserBundle\Document\User;
use Pu\UserBundle\Form\Type\AdminType;

class AccountController extends Controller
{
	/**
	 * 用户注册
	 */
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
				return $this->redirectToRoute('login');
			}
		}
		return $this->render('PuViewBundle:Front/User/Account:register.html.twig',['form'=>$form->createView()]);
	}
	/**
	 * 添加用户/管理员
	 */
	public function newAction(Request $request)
	{
		$form = $this->createForm(AdminType::class, new User(),[
				'method'=>'post',

			]);
		if ($request->getMethod()=='POST') {
			$dm = $this->get('doctrine_mongodb')->getManager();
			$form->handleRequest($request);	
			if ($form->isValid()) {
				$user = $form->getData();
				$encoder = $this->container->get('security.password_encoder');
				$password_encoded = $encoder->encodePassword($user,$user->getPassword());
				$user->setPassword($password_encoded);
				$dm->persist($user);
				$dm->flush();
				return $this->redirectToRoute('user_list');
			}
		}
		return $this->render('PuViewBundle:Admin/User/Account:form.html.twig',[
			'form'=>$form->createView(),
			'action'=>'new']);
	}
	/**
	 * 后台修改用户
	 */
	public function editAction(Request $request)
	{
		$dm = $this->get('doctrine_mongodb')->getManager();
		$uid = $request->get('id');
		$user = $dm->getRepository('PuUserBundle:User')->find($uid);

		$form = $this->createForm(AdminType::class, $user,[
				'method'=>'post',
				'action'=>$this->generateUrl('user_edit',array('id'=>$uid))
			]);
		if ($request->getMethod()=='POST') {
			
			$form->handleRequest($request);	
			if ($form->isValid()) {
				$user = $form->getData();
				$encoder = $this->container->get('security.password_encoder');
				$password_encoded = $encoder->encodePassword($user,$user->getPassword());
				$user->setPassword($password_encoded);
				$dm->persist($user);
				$dm->flush();
				return $this->redirectToRoute('user_list');
			}
		}
		return $this->render('PuViewBundle:Admin/User/Account:form.html.twig',[
			'form'=>$form->createView(),
			'action'=>'edit']);
	}
	/**
	 * 用户列表
	 */

	public function listAction(Request $request)
	{
		$dm = $this->get('doctrine_mongodb')->getManager();
		$qb = $dm->createQueryBuilder("PuUserBundle:User");
		$query = $qb->getQuery();
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->get('page',1),
			10);
		return $this->render('PuViewBundle:Admin/User/Account:list.html.twig',['pagination'=>$pagination]);
	}
}
