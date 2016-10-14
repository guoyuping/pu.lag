<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Document\Mod;
use AppBundle\Form\Type\ModType;


class ModController extends Controller
{
	public function newAction(Request $request)
	{
		$form = $this->createForm(ModType::class,new Mod(),array(
			'allow_extra_fields'=>true
			));
		if ($request->getMethod()=='POST') 
		{
			$dm = $this->get('doctrine_mongodb')->getManager();
			$form->handleRequest($request);	
			if ($form->isValid()) 
			{
				$mod = $form->getData();
				$param = json_decode($mod->getParam(),true);
				$mod->setParam($param);

				//$mod->setParam();
				$dm->persist($mod);
				$dm->flush();
				return $this->redirectToRoute('mod_list');
			}
		}

		return $this->render('Mod/new.html.twig',[
			'form'=>$form->createView(),
			'action'=>'new']);
	}

	public function editAction(Request $request)
	{
		$dm = $this->get('doctrine_mongodb')->getManager();
		$mid = $request->get('id');
		$mod = $dm->getRepository('AppBundle:Mod')->find($mid);

		$param = $mod->getParam();
		$mod->setParam(json_encode($param));
		
		$form = $this->createForm(ModType::class,$mod,array(
			'allow_extra_fields'=>true
			));
		if ($request->getMethod()=='POST') 
		{
			$form->handleRequest($request);	
			if ($form->isValid()) 
			{
				$mod = $form->getData();
				$param = json_decode($mod->getParam(),true);
				$mod->setParam($param);
				$dm->persist($mod);
				$dm->flush();
				return $this->redirectToRoute('mod_list');
			}
		}
		return $this->render('Mod/new.html.twig',[
			'form'=>$form->createView(),
			'action'=>'edit']);
	}

	public function listAction(Request $request)
	{
		$dm = $this->get('doctrine_mongodb')->getManager();
		$qb = $dm->createQueryBuilder("AppBundle:Mod");
		$query = $qb->getQuery();
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->get('page',1),
			10);
		return $this->render('Mod/list.html.twig',['pagination'=>$pagination]);
	}

	public function renderAction(Request $request)
	{

		$dm = $this->get('doctrine_mongodb')->getManager();
		$mod = $request->get('mod');
		$action = $request->get('action');
		$param = "";
		if ($action == "form") {
			$controller = $mod;
		}
		if ($action == "render") {
			// var_dump(mod)
			// array:4 [▼
			//   "controller" => "ModPicOne"
			//   "width" => 700
			//   "height" => 200
			//   "type" => "standalone"
			// ]
			$controller = $mod['controller'];
			$param = $mod;
		}


		if (!$mod || !$action) {
			throw new \Exception("Error: AppBundle:Mod:render, \"$controller\" 模块不存在！", 1);
		}
		
		
		//$mod = $dm->getRepository('AppBundle:Mod')->findOneBy(array('param.controller'=>$controller));

		$response = $this->forward("MoBundle:$controller:$action",array('param'=>$param));
		return $response;
	}

}
