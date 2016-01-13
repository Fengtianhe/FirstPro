<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function _initialize(){
        header("Content-type:text/html;charset=utf-8");
    }
    public function getIPaddress(){
        $IPaddress='';
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $IPaddress = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $IPaddress = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $IPaddress = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $IPaddress = getenv("HTTP_CLIENT_IP");
            } else {
                $IPaddress = getenv("REMOTE_ADDR");
            }
        }
        return $IPaddress;
    }
    public function taobaoIP(){
        $clientIP = $this->getIPaddress();
        $taobaoIP = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$clientIP;
        $IPinfo = json_decode(file_get_contents($taobaoIP));
        $province = $IPinfo->data->region;
        $city = $IPinfo->data->city;
        //$data = $province.$city;
        return $data;
    }
    public function index()
    {  
        $prov = M('province');
        $provs = $prov->select();
        $this->assign('provs',$provs);
        if ($_GET['province']) {
            $provinceid = $_GET['province'];
            $province = $prov->where(array('provinceid'=>$provinceid))->find();
            $ci = M('city');
            $citys = $ci->where(array('fatherid'=>$provinceid))->select();
            $this->assign('citys',$citys);
            $this->assign('province',$province['province']);     
        }
        if ($_GET['city']) {
            $this->assign('area',$_GET['city']); 
        }
        $data = $this->taobaoIP();
        $this->assign('city',$data);
        $offset = 0;
        $limit  = 4;
        $category = M('Category')->where(array('pid'=>'0'))->select();

        //获取推荐内容
        $map = array();
        $map['id_del'] = array('neq',1);
        $map['is_top'] = 1;
        $News = D('News');
        $top_list = $News->where($map)->order('id desc')->limit($offset.','.$limit)->select();

        $this->assign('category',$category);
        $this->assign('top_list',$top_list);
    	$this->display();
    }

    public function ajaxLoading()
    {
    	$offset = I('offset',0);
    	$limit = I('limit',10);
    	$category_id = I('category_id',0);
    	$map = array();
    	$map['id_del'] = array('neq',1);
    	if($category_id)
    	{
    		$map['category_id'] = $category_id;
    	}
    	$News = D('News');
    	$list = $News->where($map)->order('id desc')->limit($offset.','.$limit)->select();
    	$this->ajaxReturn($list);
    }

}