<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends CommonController {
    public function index()
    {
        $id = I('id', 0);
        $query = I('query', '');
        if ($id || $query) {
            if ($id) {
                $where['id'] = $id;
            }
            if ($query) {
                $where['query'] = $query;
            }
            $article = D('Article')->where($where)->find();
            $this->assign('article', $article);
            $this->display();
        } else {
            $this->error('内容不存在','/');
        }
    }
}