<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Model\Registration;
use AppBundle\Form\Type\RegistrationType;
use AppBundle\Document\User;
use AppBundle\Form\Type\AdminType;

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
				$user->addRole($dm->getRepository('AppBundle:Role')->findOneByRole('ROLE_USER'));
				$dm->persist($user);
				$dm->flush();
				return $this->redirectToRoute('login');
			}
		}
		return $this->render('User/register.html.twig',['form'=>$form->createView()]);
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
		return $this->render('User/account_form.html.twig',[
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
		$user = $dm->getRepository('AppBundle:User')->find($uid);

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
		return $this->render('User/account_form.html.twig',[
			'form'=>$form->createView(),
			'action'=>'edit']);
	}
	/**
	 * 用户列表
	 */

	public function listAction(Request $request)
	{
		$dm = $this->get('doctrine_mongodb')->getManager();
		$qb = $dm->createQueryBuilder("AppBundle:User");
		$query = $qb->getQuery();
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->get('page',1),
			10);
		return $this->render('User/account_list.html.twig',['pagination'=>$pagination]);
	}
}
