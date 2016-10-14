<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Document\Tpl;
use AppBundle\Form\Type\TplType;
class TplController extends Controller
{
	public function newAction(Request $request)
	{
		$form = $this->createForm(TplType::class,new Tpl(),array(
			'allow_extra_fields'=>true
			));
		if ($request->getMethod()=='POST') 
		{
			$dm = $this->get('doctrine_mongodb')->getManager();
			$form->handleRequest($request);	
			if ($form->isValid()) 
			{
				$tpl = $form->getData();
				$param = json_decode($tpl->getParam(),true);
				$tpl->setParam($param);
				$dm->persist($tpl);
				$dm->flush();
				
				return $this->redirectToRoute('tpl_list');
			}
		}

		return $this->render('Tpl/new.html.twig',[
			'form'=>$form->createView(),
			'action'=>'new']);
	}

	public function editAction(Request $request)
	{
		$dm = $this->get('doctrine_mongodb')->getManager();
		$tid = $request->get('id');
		$tpl = $dm->getRepository('AppBundle:Tpl')->find($tid);

		$param = $tpl->getParam();
		$tpl->setParam(json_encode($param));
		
		$form = $this->createForm(TplType::class,$tpl,array(
			'allow_extra_fields'=>true
			));
		if ($request->getMethod()=='POST') 
		{
			$form->handleRequest($request);	
			if ($form->isValid()) 
			{
				$tpl = $form->getData();
				$param = json_decode($tpl->getParam(),true);
				$tpl->setParam($param);
				$dm->persist($tpl);
				$dm->flush();
				return $this->redirectToRoute('tpl_list');
			}
		}
		return $this->render('Tpl/new.html.twig',[
			'form'=>$form->createView(),
			'action'=>'edit']);
	}

	public function listAction(Request $request)
	{
		$dm = $this->get('doctrine_mongodb')->getManager();
		$qb = $dm->createQueryBuilder("AppBundle:Tpl");
		$query = $qb->getQuery();
		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->get('page',1),
			10);
		return $this->render('Tpl/list.html.twig',['pagination'=>$pagination]);
	}
	public function renderAction(Request $request)
	{
		$tid = $request->get('id');
		if (!$tid) {
			throw new \Exception("未指定模板！", 1);
		}
		$dm = $this->get('doctrine_mongodb')->getManager();
		$tpl = $dm->getRepository('AppBundle:Tpl')->find($tid);
		if (!$tpl) {
			throw new \Exception("模板不存在！", 1);
		}
		$param = $tpl->getParam();
		$controller = $param['controller'];
		$mods = $param['mods'];
		$forms = array(); //去重后的，tpl里所有mod的controller名，用于自动插入的form页的模板
		$mixed = array(); //去重后的，mix type下子mod需要自动插入的render页的模板（用来展示插入内容）
		$this->getMods($mods,$forms,$mixed,0);

		$response = $this->forward("TplBundle:$controller:render",array('mods'=>$forms,'mixs'=>$mixed));
		return $response;
	}
	/**
	 * 去重
	 * 获取tpl中form页和需要预插入的mix下的render页
	 * $flag = 1 是mix子模块，= 0是独立模块
	 */
	private function getMods($mods,&$forms,&$mixed,$flag=0)
	{
		foreach ($mods as $mod) {
			
			if (!in_array($mod['controller'],$forms)) {
				$forms[] = $mod['controller'];
			}
			//如果是mixed里的子mod
			if ($flag==1) {
				if (!array_key_exists($mod['controller'],$mixed)) {
					$mixed[$mod['controller']] = $mod;
				}
			}
			if ($mod['type']=='mixed') {
				$this->getMods($mod['mods'],$forms,$mixed,1);
			}
		}
	}
}
