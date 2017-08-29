<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 0:56
 */
namespace app\admin\controller;

use think\Controller;
class Admin extends Error {
    public function index(){
        $data=db('manager')->paginate(2);
        $this->assign('data',$data);
        return $this->fetch('list');
    }
    public function add(){
        if(request()->isPost()){
            $data=[
                'username'=>input('username'),
                'password'=>md5(input('password')),
                'is_lock'=>input('is_lock')
            ];
            $validate = validate('Admin');
            if(!$validate->scene('add')->check($data)){
                return $this->error($validate->getError());
            }
            //判断state状态
            if (input('is_lock') == 'on') {
                $data['is_lock'] = 1;
            } else {
                $data['is_lock'] = 0;
            }
            $r=db('manager')->insert($data);
            if($r){
                return $this->success('添加成功',url('Admin/index'));
            }else{
                return $this->error('添加失败');
            }

        }
        return $this->fetch('add');
    }
    public function edit(){
        $id=input('id');
        $data=db('manager')->find($id);
        $this->assign('data',$data);
        return $this->fetch('');
    }
    public function doEdit(){
        $password=input('password');
        $data=[
            'id'=>input('id'),
            'username'=>input('username'),
            'is_lock'=>input('is_lock'),
        ];
        if ($password!=''){
            $data['password']=md5($password);
        }
//        $validate = validate('Admin');
//        if(!$validate->scene('edit')->check($data)){
//            return $this->error($validate->getError());
//        }
        $r=db('manager')->update($data);
        if($r){
            return $this->success('修改成功',url('Admin/index'));
        }else{
            return $this->error('修改成功');

        }
    }
    public function  del(){
        $id=input('id');
        $r = db('manager')->delete($id);
        if($r){
            return $this->success('删除成功',url('Admin/index'));
        }else{
            return $this->error('删除失败');
        }
    }

}