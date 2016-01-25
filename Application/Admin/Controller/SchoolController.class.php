<?php
namespace Admin\Controller;
use Think\Controller;
class SchoolController extends CommonController {
    public $school_status = array(
            0 => array('id'=>0, 'name'=>'正常'),
            1 => array('id'=>1, 'name'=>'开通'),
            -1 => array('id'=>-1, 'name'=>'关闭'),
        );
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
    }
    public function lists(){
        $area_tree = gatAreaData();

        if (I('request.s_name', 0)) {
            $where['s_name'] = trim(I('request.s_name'));
        }
        if (I('request.province_id', 0)) {
            $where['province_id'] = trim(I('request.province_id'));
        }
        if (I('request.city_id', 0)) {
            $where['city_id'] = trim(I('request.city_id'));
        }
        $school_list = M('University_all')->where($where)->select();

        $this->assign('school_status', $this->school_status);
        $this->assign('area_tree', $area_tree);
        $this->assign('school_list', $school_list);
    	$this->display();

        /*//
        $User = M('User'); // 实例化User对象
        $count      = $User->where('status=1')->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $User->where('status=1')->order('create_time')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display(); // 输出模板*/
    }

    public function editor_school(){
        $id = I('id', 0);
        $area_tree = gatAreaData();
        if ($id) {
            $school_info = M('university_all')->where(array('id'=>$id))->find();
            $this->assign('school_info', $school_info);
        }
        $this->assign('area_tree', $area_tree);
        $this->display();
    }

    public function saveSchool(){
        $id = I('request.id', 0);
        
        $data['s_name'] = I('s_name','');
        $data['province_id'] = I('province_id',0);
        $data['city_id']     = I('city_id',0);
        $data['status']     = I('request.status',0);
        foreach ($data as $key=>$value) {
            if (!$value) {
                unset($data[$key]);
            }
        }
        if ($id) {
            M('university_all')->where(array('id'=>$id))->save($data);
        } else {
            M('university_all')->add($data);
        }

        $result['statusCode'] = "200";
        $result['message']   = "修改成功";
        $result['navTabId'] = "school";
        $result['rel']   = "school";
        if (I('close_dialog') == 1) {
            $result['callbackType'] = "closeCurrent";
        }
        $result['forwardUrl']   = "";
        $result['confirmMsg'] = "";
        $this->ajaxReturn($result);
    }
}