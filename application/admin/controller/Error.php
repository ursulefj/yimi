<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/28
 * Time: 16:25
 */
namespace app\admin\controller;

use think\Controller;

class Error extends Controller{
    public function _empty(){
        return $this->error('页面不存在');
    }
}