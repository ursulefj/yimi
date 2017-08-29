<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 10:55
 */
namespace app\admin\controller;

use app\admin\model\Cate as CateModel;
use think\Request;
class Cate extends Error
{
    public function index()
    {
        $data = CateModel::getAllCate(5);
        $this->assign('data', $data);
        return $this->fetch('list');
    }
    public function topCate(){
        $data=db('cate')->where('level','0')->paginate(5);

        $this->assign('data',$data);
        return$this->fetch('topCateList');
    }
    public function addTopCate(){
        if ($this->request->isPost()) {
            $name=$this->request->param('name');
            $pid=0;
            $level=0;
            $data=[
                'pid'=>$pid,
                'name'=>$name,
                'level'=>$level
            ];
            $r=CateModel::topCate($data);
            if ($r) {
                return $this->success('添加成功', url('Cate/topCate'));
            } else {
                return $this->error('添加失败');
            }
        }
        return$this->fetch('addTopCate');
    }
    public function editTopCate()
    {
        $id = input('id');
        $data=CateModel::getCateById($id);
        $this->assign('data', $data);
        return $this->fetch('');
    }
    public function doEditTopCate()
    {
        $data = [
            'id' => input('id'),
            'name' => input('name'),
        ];
        $r = db('cate')->update($data);
        if ($r) {
            return $this->success('修改成功', url('Cate/topCate'));
        } else {
            return $this->error('修改成功');

        }
    }

    public function addCate(){
        $id=input('id');
        $data=CateModel::getCateById($id);
        $this->assign('data', $data);
        return $this->fetch('addCate');
    }
    public function doAddCate(){
        $data=[
            'id'=>input('id'),
            'name'=>input('name')
        ];
        $r=CateModel::addCate($data);
        if ($r) {
            return $this->success('添加成功', url('Cate/index'));
        } else {
            return $this->error('添加失败');
        }
    }



    public function add()
    {
        //        查询所有栏目
        $cate = CateModel::getAllCate(100);
        $this->assign('cate', $cate);
        return $this->fetch('add');
    }
    public function doAdd(){
        $data = [
            'id' => input('id'),
            'name' => input('name'),
        ];

    }

    public function edit()
    {
        $id = input('id');
        $data = db('cate')->find($id);
        $this->assign('data', $data);
        return $this->fetch('');
    }

    public function doEdit()
    {
        $data = [
            'id' => input('id'),
            'catename' => input('catename'),
        ];
        $validate = validate('Cate');
        if (!$validate->scene('edit')->check($data)) {
            return $this->error($validate->getError());
        }
        $r = db('cate')->update($data);
        if ($r) {
            return $this->success('修改成功', url('Cate/index'));
        } else {
            return $this->error('修改成功');

        }
    }

    public function del()
    {
        $id = input('id');
        $r = db('cate')->delete($id);
        if ($r) {
            return $this->success('删除成功', url('Cate/index'));
        } else {
            return $this->error('删除失败');
        }
    }
}