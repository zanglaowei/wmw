<?php
/*购物车模块
*@
*/ 
class CartAction extends CommonAction {

	
			function _initialize() {
			parent::_initialize();	
			header("Content-Type:text/html; charset=utf-8");
			import('ORG.Net.Cart');
			$this->cart = new Cart ();
	
				
    }

//购物车增加，
	
	
   public function cartadd(){
				$Food=M('Food');
				$data['fid']=$this->_get('id');
				//$data['sid']=$this->_get('id');
				$fooditem=$Food->where($data)->find();
				$status = $this->cart->insert ( array (
				'id' => $fooditem['fid'],
				'name' => $fooditem['fname'],
				'qty' => 1,
				'price' => $fooditem['fprice'],
				'sid' => $fooditem['sid'],
				'fcid' => $fooditem['fcid']
		) );
   
   //dump($data);
   //header("location:".$_SERVER["HTTP_REFERER"]);
  $this->redirect(U('./Cart/cart'));

   
   }
   
   //购物车增加，
	
	
   public function cartadds(){
   		    $Food=M('Food');
			$data['fid']=$this->_get('id');
			//$data['sid']=$this->_get('id');
			$fooditem=$Food->where($data)->find();
		    $status = $this->cart->insert ( array (
				'id' => $fooditem['fid'],
				'name' => $fooditem['fname'],
				'qty' => 1,
				'price' => $fooditem['fprice'],
				'sid' => $fooditem['sid'],
				'fcid' => $fooditem['fcid']
		) );
   
   //dump($data);
  header("location:".$_SERVER["HTTP_REFERER"]);
  //$this->redirect(U('Cart/cart'));

   
   }
   
   
   	//点餐完成后提交订单，弹出对话框，
	
	
   public function cart(){
   
   $cartdata = $this->cart->contents ();
	//dump($cartdata);
	$total = $this->cart->total ();
	$total_items = $this->cart->total_items ();
	
	$this->assign ( 'cartdata', $cartdata );//购物车数据
	$this->assign ( 'total', $total );//购物车总额
	$this->assign ( 'total_items', $total_items );//购物车总额

    $this->display();
   
  
   
   }
   
   
   
	//点餐完成后提交订单，弹出对话框，
	
	
   public function index(){
   
   $cartdata = $this->cart->contents ();
	//dump($cartdata);
	$total = $this->cart->total ();
	$total_items = $this->cart->total_items ();
	
	$this->assign ( 'cartdata', $cartdata );//购物车数据
	$this->assign ( 'total', $total );//购物车总额
	$this->assign ( 'total_items', $total_items );//购物车总额

    $this->display();
   
  
   
   }
   
         //购物车更新
   	    public function cartupdate(){
		$rowid=$this->_get('id');
		$cid=$this->_get('cid');
		$qtys=$_SESSION['cart_contents'][$rowid]['qty'];
	     $qty=$qtys+$cid;
		 $status = $this->cart->update ( array (
				'rowid' => $rowid,
				'qty' => $qty
		) );

   
	 header("location:".$_SERVER["HTTP_REFERER"]);
   }
   
   
          //购物车更新
   	    public function cartupdates(){
		$rowid=I('id');
		$cid=I('cid');
		$qtys=$_SESSION['cart_contents'][$rowid]['qty'];
	     $qty=$qtys+$cid;
		 $status = $this->cart->update ( array (
				'rowid' => $rowid,
				'qty' => $qty
		) );

   
	$this->redirect('Cart/index');
   }  
   	
	   //购物车清空
   	    public function cartclear(){
	  $this->cart->destroy ();
		  header("location:".$_SERVER["HTTP_REFERER"]);
  
   }
   
   
   
   
	
   //输入信息完成后，进成提交成功页
	
	
	public function cartcheck(){
	$data['oman']=I('oman');
	$data['otel']=I('otel');
	
	$data['oraddress']=I('oaddress');
	$data['morecontent']=I('ocontent');
	$cartdata = $this->cart->contents ();
	 $total = $this->cart->total ();
	$total_items = $this->cart->total_items ();
	
	$this->assign ( 'cartdata', $cartdata );//购物车数据
	$this->assign ( 'total', $total );//购物车总额
	$this->assign ( 'total_items', $total_items );//购物车总额
   //dump($data);
   $this->display();
   
   }
	
	 //订单保存
	public function cartsave(){	
	$Order=D('Foodorder');	
    $data['otel']=$this->_post('otel');//联系手机号
	$data['oman']=$this->_post('oman');//联系人
	$data['pid']=cookie('PHPSESSID');//联系人
	cookie('otel',$data['otel'],2592000);
	$data['oaddress']=$this->_post('oaddress');//联系址址
	$data['order_dtime']=$this->_post('orderdtimes');//吃饭时间	
	$data['morecontent']=$this->_post('morecontent');//备注	
	if(!$data['oaddress']){$this->message('外卖地址不可以为空');};
	if(!$data['otel']){$this->message('电话不可以为空');};
	$data['orderprice']=$this->cart->total();//购物车商品总价格
	$data['ordercount']=$this->cart->total_items();//购物车商品总数量
	$data['order_ctime']=time();//提交时间
	
	$cartdata = $this->cart->contents ();
	
	 foreach ($cartdata as $k=>$age) {
    $ages[$k]=Array(
	'fid'=>$age['id'],
	'fname'=>$age['name'],
	'fcount'=>$age['qty'],
	'fprice'=>$age['price'],
	'prices'=>$age['subtotal'],	
	);
	send_mail("1207491516@qq.com","测试订单",$cartdata);    
}//将session中的数据转化成数组
$data['Foodorderext']=$ages;


$result =$Order->relation(true)->add($data);

if($result){
      $this->cart->destroy ();
		 // header("location:".$_SERVER["HTTP_REFERER"]);
		$this->redirect(U('Cart/cartend'));
} else {
    //错误页面的默认跳转页面是返回前一页，通常不需要设置
  $this->message('提交失败');
}

}


	public function cartend(){
	$pid=cookie('PHPSESSID');
	//dump($pid);
	$this->assign('pid',$pid);
	
	$this->display ();
	
	
	
	
	}







	public function message($msg = '') {
		$this->assign ( 'msg', $msg );
		$this->display ( 'message' );
		exit ();
	}




}