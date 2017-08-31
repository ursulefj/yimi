<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 16:16
 */
namespace app\index\controller;

use think\Controller;

class Register extends Error
{
    public function index()
    {

        return $this->fetch('passport-register');
    }
    public function add(){

        $data=[
            'username'=>input('mobile'),
            'password'=>md5(input('password')),
            'ip'=>$_SERVER['SERVER_ADDR'],
            'reg_time'=>time()
        ];
        $r=db('member')->insert($data);
        if ($r) {
            return $this->success('注册成功', url('Index/index'));
        } else {
            return $this->error('注册成功');
        }
    }
}