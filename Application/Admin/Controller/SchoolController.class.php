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
        $limit = 15;
        $pageNum        = I('pageNum', 1);
        $orderField     = I('orderField', 'id');
        $orderDirection = I('orderDirection', 'desc');
        $numPerPage     = I('numPerPage', $limit);
        
        $offset = ($pageNum -1) * $limit;
        if (I('request.s_name', 0)) {
            $where['s_name'] = trim(I('request.s_name'));
        }
        if (I('request.province_id', 0)) {
            $where['province_id'] = trim(I('request.province_id'));
        }
        if (I('request.city_id', 0)) {
            $where['city_id'] = trim(I('request.city_id'));
        }
        if (I('request.status', 0)) {
            $where['status'] = trim(I('request.status'));
        }
        if (I('request.start_time', 0) && I('request.end_time', 0)) {
            $where['created'] =  array(array('gt',strtotime(trim(I('request.start_time')))),array('lt',strtotime(trim(I('request.end_time')))));
        }
        $area_tree = gatAreaData();
        $totalCount  = M('University_all')->where($where)->count('id');
        $school_list = M('University_all')->where($where)->order($orderField.' '.$orderDirection)->limit($offset.','.$limit)->select();
        $page = array('pageNum'=>$pageNum, 'orderField'=>$orderField, 'orderDirection'=>$orderDirection, 'numPerPage'=>$numPerPage, 'totalCount'=>$totalCount);
        $this->assign('page', $page);
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
            $data['created'] = time();
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