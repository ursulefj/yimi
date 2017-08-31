<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 13:45
 */
namespace app\index\widget;

use think\Controller;

class Shop extends Controller{
    public function header(){
        return $this->fetch('common/header');
    }
    public function footer(){
        return $this->fetch('common/footer');

    }
    public function __construct()
    {
        parent::__construct();
        $this->isLogin();
    }
    //判断是否登录
    public function isLogin(){
        $member=session('member');
        if(isset($member)){
            return $this->fetch('Index/index');
        }
    }
}