<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/28
 * Time: 16:21
 */
namespace app\admin\controller;

class Login extends Error{
    public function index(){
        return $this->fetch('login');
    }
    public function login()
    {
        if (request()->isPost()) {
            $data = [
                'username' => input('username'),
                'password' => input('password'),
                'code' => input('code')
            ];
            //判断验证码是否为空
            if($data['code']==''||!$data['code']){
                return $this->error('验证码不能为空',url('Login/index'));
            }
            //判断验证码是否正确
            if(!captcha_check($data['code'])){
                return $this->error('验证码错误',url('Login/index'));
            }
            //判断账户是否为空
            if($data['username']==''||!$data['username']){
                return $this->error('用户名不能为空',url('Login/index'));
            }
            //检查密码是否为空
            if ($data['password'] == '' || !$data['password']){
                return $this->error('密码不能为空', url('Login/index'));
            }

            $r = db('manager')->where(['username' => $data['username']])->find();

            //判断账号是否存在
            if (!$r) {
                return $this->error('账号或密码错误', url('Login/index'));
            }
            //判断密码是否正确
            if ($r['password'] !== md5($data['password'])) {
                return $this->error('账号或密码错误', url('Login/index'));
            }

            //设置session
            if($r['is_lock']==0){
                session('manager', $r);
                return $this->fetch('Index/index');
            }else{
                return $this->error('账号已冻结');
            }
        }
    }
    public function out(){

        session(null);
        return $this->fetch('Login/login');
    }
}

