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

        $school_list = M('University_all')->select();

        $this->assign('school_status', $this->school_status);
        $this->assign('area_tree', $area_tree);
        $this->assign('school_list', $school_list);
    	$this->display();
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

        $result['statusCode'] = "OK";
        $result['message']   = "修改成功";
        $result['navTabId'] = "";
        $result['rel']   = "school";
        $result['callbackType'] = "closeCurrent";
        $result['forwardUrl']   = "";
        $result['confirmMsg'] = "";

        $this->ajaxReturn($result);
    }
}