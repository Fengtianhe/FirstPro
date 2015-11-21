<?php
namespace Editor\Controller;
use Editor\Controller;
class AddController extends CommonController {
    public $neworold = array(
        '9' => array('name'=>'九成新'),
        '8' => array('name'=>'八成新'),
        '7' => array('name'=>'七成新'),
        '6' => array('name'=>'六成新'),
        '5' => array('name'=>'五成新'),
        '0' => array('name'=>'其他')
        );
    public function _initialize(){
        parent::_initialize();
    }

    public function addNew(){
        $category = D('Category')->select();                                                                                     
        $this->assign('category',$category);
        $this->assign('neworold',$this->neworold);
        $this->display();
    }

    public function saveNew(){
        $data['title']        = I('title','');
        $data['keyword']      = I('keyword','');
        $data['description']  = I('description','');
        $data['price']        = I('price','');
        $data['img']          = I('img','');
        $data['category_id']  = I('category','');
        $data['neworold']     = I('neworold','');
        $data['phone']        = I('phone',0);
        $data['relation_name']     = I('yourname','');
        $data['user_id']      = $_SESSION['me']['id'];
        if(I('id')){
            $data['updated'] = time();
            D('News')->where(array('id'=>I('id')))->save($data);
            D('content')->where(array('news_id'=>I('id')))->save(array('content'=>I('editorValue')));
        }else{
            $data['created'] = time();
            $id = D('News')->add($data);
            D('content')->add(array('news_id'=>$id,'content'=>I('editorValue')));
        }
        $this->success('发布成功');
    }
    public function show(){
        var_dump($_SESSION);die();
        $arr = D('content')->where(array('news_id'=>I('id')))->find();
        var_dump($arr);
        echo htmlspecialchars_decode($arr['content']);
    }

    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $src = $info['file']['savepath'].$info['file']['savename'];
            $this->ajaxReturn(array('status'=>1,'message'=>'上传成功','src'=>$src));
        }
    }
}