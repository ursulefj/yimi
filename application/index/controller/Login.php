<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 16:14
 */
namespace app\index\controller;

use think\Controller;

class Login extends Error
{
    public function index()
    {
        return $this->fetch('passport-login');
    }
    public function login(){
        if(request()->isPost()){
            $data=[
                'username'=>input('username'),
                'password'=>input('password')
            ];
            //判断账户是否为空
            if($data['username']==''||!$data['username']){
                return $this->error('用户名不能为空',url('Login/index'));
            }
            //检查密码是否为空
            if ($data['password'] == '' || !$data['password']){
                return $this->error('密码不能为空', url('Login/index'));
            }
            $r=db('member')->where(['username'=>$data['username']])->find();
            if(!$r){
                return $this->error('账号或密码错误',url('Login/index'));
            }
            if($r['password']!==md5($data['password'])){
                return $this->error('账号或密码错误',url('Login/index'));
            }
            if($r){
                return $this->success('登录成功','Index/index');
            }{
                return $this->error('登录失败');
            }

            //设置session
            if($r['is_lock']==0){
                session('member', $r);
                return $this->fetch('Index/index');
            }else{
                return $this->error('账号已冻结');
            }
        }
    }
}