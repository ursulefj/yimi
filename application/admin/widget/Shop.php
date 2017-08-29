<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 1:03
 */
namespace app\admin\widget;

use think\Controller;

class Shop extends Controller
{
    public function header()
    {
        return $this->fetch('common/header');
    }

    public function left()
    {
        return $this->fetch('common/left');
    }
    public function __construct()
    {
        parent::__construct();
        $this->isLogin();
    }
    //判断是否登录
    public function isLogin(){
        $manager=session('manager');
        if(!isset($manager)||!$manager['id']){
            return $this->error('请先登录',url('Login/index'));
        }
    }
    public function _empty(){
        echo '非法';
        exit;
    }

}