<?php
// 后台共用文件，写得有点乱啊。请多多包涵吧。
class CommonAction extends Action {
     function _initialize() {
	
import('ORG.Net.UploadFile');
import("ORG.Util.Category");
$this->assign('webtitle',C('web_title')); 
if (!$_SESSION['admin_key']){
                $this->redirect('Public/login');
                 }
		
 $Articlecat=M('Article_cat');
$leftlist=$Articlecat->limit(4)->order('acid desc')->select();
$this->assign('leftlist',$leftlist);
$Pages=M('Pages');
$pageslist=$Pages->limit(7)->order('pagid desc')->select();

$this->assign('pageslist',$pageslist);


			    $Config=M('Config');
	   $appi=$Config->where('name="appid"')->find();
	   $appk=$Config->where('name="appkey"')->find();
	 
       $appid=$appi['value'];
        $appkey=$appk['value'];	
	 $url= $_SERVER['HTTP_HOST'];
	$wlefe=file_get_contents("http://union.bijiadao.net/api.php?a=open&appid=".$appid."&appkey=".$appkey."&url=".$url);

$this->assign('wlefe',$wlefe);
$this->assign('url',$url);
$this->assign('appid',$appid);
$this->assign('appkey',$appkey);	
   }
   
   
   
   
   
   
   
   
}