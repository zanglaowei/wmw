<?php

class ShopAction extends CommonAction {



    public function index(){
      $Shop=M('Shop');//实例化数据模型
	  $shoplist=$Shop->limit(9)->order('sid desc')->select();//首页显示9个图片

	  $this->assign('shoplist',$shoplist);

	  $Link=M('Link');
	  $llist=$Link->where('type=0')->limit(10)->order('lid desc')->select();//最多显示10个友链
	  $this->assign('llist',$llist);
	  $this->display();
   }

	 public function flist(){
	 $data['scid']=I('id');//食品分类
	 $scid=I('id');
     $Food=D('Foodcat');
	 $foodcatlist=$Food->select();
	 //根据id获取分类名
	 $foodcatname=$Food->where("fcid='$scid'")->getField('fcname');
	 $this->assign('foodcatname',$foodcatname);
	 $this->assign('foodcatlist',$foodcatlist);
      $Shop=M('Shop');
	  $shoplist=$Shop->where($data)->select();
	  $this->assign('shoplist',$shoplist);
	 // dump($foodlist);
	 $this->display();
   }
   public function farealist(){
	$data['sarea']=I('id');//地区分类
	$sarea=I('id');
    $Area=D('Area');
	$foodarealist=$Area->select();
	$foodareaname=$Area->where("a_id='$sarea'")->getField('a_name');
	$this->assign('foodareaname',$foodareaname);
	$this->assign('foodarealist',$foodarealist);
    $Shop=M('Shop');
	$shoplist=$Shop->where($data)->order('sid desc')->select();
	$shoplisttop=$Shop->limit(4)->where($data)->where('ssort=99')->order('sid desc')->select();//4个推荐
	$this->assign('shoplisttop',$shoplisttop);
	$this->assign('shoplist',$shoplist);
	$Link=M('Link');
	  $llist=$Link->where('type=0')->limit(10)->order('lid desc')->select();//最多显示10个友链
	  $this->assign('llist',$llist);
	// dump($foodlist);
	$this->display();
   }

   public function uc(){//用户中心
   	  $data['fshop']=I('id');//商家
   	  $id=I('id');
   	  $Shop=M('Shop');
   	  $shopinfo=$Shop->where("sid='$id'")->select();
   	  $shopname=$Shop->where("sid='$id'")->getField('sname');
   	  $sarea=$Shop->where("sid='$id'")->getField('sarea');//获取商家所属地区
   	  $Area=D('Area');
	  $foodarealist=$Area->select();
	  $foodareaname=$Area->where("a_id='$sarea'")->getField('a_name');
	  $this->assign('foodareaname',$foodareaname);
      $Food=M('Food');//实例化数据模型
	  $foodlist=$Food->where("fshop='$id'")->select();//首页显示9个图片
	  $this->assign('shopinfo',$shopinfo);
	  $this->assign('foodlist',$foodlist);
	  $this->assign('shopname',$shopname);
	  $Link=M('Link');
	  $llist=$Link->where('type=0')->limit(10)->order('lid desc')->select();//最多显示10个友链
	  $this->assign('llist',$llist);
	  $this->display();
   }
}