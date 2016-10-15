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
		//不再预先插入render模板 2016-10-14
		$mixed = array(); //去重后的，mix type下子mod需要自动插入的render页的模板（用来展示插入内容）
		$pmods = array();

		//TODO
		//让每个模块都保护模板信息
		$this->getMods($tid,$mods,$pmods,$forms,$mixed,0);
		$params = array('tpl'=>json_encode($tpl),'mods'=>$pmods,'forms'=>$forms);
		print_r($tpl);
		$response = $this->forward("TplBundle:$controller:render",array('params'=>$params));
		return $response;
	}
	/**
	 * 去重
	 * 获取tpl中form页和需要预插入的mix下的render页
	 * $flag = 1 是mix子模块，= 0是独立模块
	 */
	private function getMods($tpl,$mods,&$pmods,&$forms,&$mixed,$flag=0)
	{
		foreach ($mods as $mod) {
			$mod['tpl'] = $tpl;
			if (!array_key_exists($mod['controller'],$forms)) {
				$forms[$mod['controller']] = $mod;
			}
			//如果是mixed里的子mod
			if ($flag==1) {
				if (!array_key_exists($mod['controller'],$mixed)) {
					$mixed[$mod['controller']] = $mod;
				}
			}else{
				$pmods[$mod['position']] = $mod;
			}
			if ($mod['type']=='mixed') {
				$this->getMods($tpl,$mod['mods'],$pmods,$forms,$mixed,1);
			}
		}
	}
	// public function getSubModsAction(Request $request)
	// {
	// 	$t = $
	// }
}
