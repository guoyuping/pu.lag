<?php

namespace AppBundle\Controller\Mod;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Document\Mod;
use AppBundle\Form\Type\ModType;
use AppBundle\Form\Model\Moudle;
use AppBundle\Form\Type\MoudleType;

class ModController extends Controller
{
	public function newAction(Request $request)
	{
		$form = $this->createForm(MoudleType::class,new Moudle(),array(
			'allow_extra_fields'=>true
			));
		if ($request->getMethod()=='POST') 
		{
			$dm = $this->get('doctrine_mongodb')->getManager();
			$form->handleRequest($request);	
			if ($form->isValid()) 
			{
				$moudle = $form->getData();
				$mod = $moudle->getMod();
				$params = $moudle->getParams();
				$data = [];
				foreach ($params as $key => $value) {
					$arr = explode(':',$value);
					if (count($arr)==1) {
						$k = $value;
						$v = "";
					}else{
						$k = $arr[0];
						$v = $arr[1];
					}
					$data[$k] = $v;
				}
				$mod->setParam($data);
				$dm->persist($mod);
				$dm->flush();
				//return $this->redirectToRoute('mod_list');
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
		$params = $mod->getParam();

		$data = [];
		if (!empty($params)) {
			foreach ($params as $key => $value) {
				$data[] = $value!=""?$key.':'.$value:$key;
			}
		}
		
		$moudle = new Moudle();
		$moudle->setMod($mod);

		$moudle->setParams($data);

		$form = $this->createForm(MoudleType::class,$moudle,array(
			'allow_extra_fields'=>true
			));
		if ($request->getMethod()=='POST') 
		{
			$form->handleRequest($request);	
			if ($form->isValid()) 
			{
				$moudle = $form->getData();
				$mod = $moudle->getMod();
				$params = $moudle->getParams();
				$data = [];
				foreach ($params as $key => $value) {
					$arr = explode(':',$value);
					if (count($arr)==1) {
						$k = $value;
						$v = "";
					}else{
						$k = $arr[0];
						$v = $arr[1];
					}
					$data[$k] = $v;
				}
				$mod->setParam($data);
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

}
