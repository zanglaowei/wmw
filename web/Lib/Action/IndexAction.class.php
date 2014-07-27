<?php

class IndexAction extends CommonAction {



    public function index(){
      //$Food=M('Food');//实例化Food数据模型
	  //$foodlist=$Food->limit(8)->order('fid desc')->select();//首页显示8个图片
	  //$this->assign('foodlist',$foodlist);
	  $Shop=D('Shop');
      $shoplist=$Shop->limit(8)->order('sid desc')->select();//8个最新商家
      $shoplisttop=$Shop->limit(8)->where('ssort=99')->order('sid desc')->select();//8个推荐
      $this->assign('shoplist',$shoplist);
      $this->assign('shoplisttop',$shoplisttop);
	  $Link=M('Link');
	  $llist=$Link->where('type=0')->limit(10)->order('lid desc')->select();//最多显示10个友链
	  $this->assign('llist',$llist);
	 // dump($foodlist);
	  $this->display();
   }

	 public function flist(){
	 $data['fcid']=I('id');//食品分类
	 $fcid=I('id');
     $Food=D('Foodcat');
	 $foodcatlist=$Food->select();
	 //根据id获取分类名
	 $foodcatname=$Food->where("fcid='$fcid'")->getField('fcname');
	 $this->assign('foodcatname',$foodcatname);
	 $this->assign('foodcatlist',$foodcatlist);
      $Food=M('Food');
	  $foodlist=$Food->where($data)->select();
	  $this->assign('foodlist',$foodlist);
	 // dump($foodlist);
	 $this->display();
   }
   public function farealist(){
	$data['farea']=I('id');//地区分类
	$farea=I('id');
    $Area=D('Area');
	$foodarealist=$Area->select();
	$foodareaname=$Area->where("a_id='$farea'")->getField('a_name');
	$this->assign('foodareaname',$foodareaname);
	$this->assign('foodarealist',$foodarealist);
      $Food=M('Food');
	  $foodlist=$Food->where($data)->select();
	  $this->assign('foodlist',$foodlist);
	  $Link=M('Link');
	  $llist=$Link->where('type=0')->limit(10)->order('lid desc')->select();//最多显示10个友链
	  $this->assign('llist',$llist);
	 // dump($foodlist);
	 $this->display();
   }
   	//发送邮件测试
    public function smail(){
    send_mail("1207491516@qq.com","测试标题","测试内容");
    //$this->assign('title','测试标题');
    $this->display();
	}

}