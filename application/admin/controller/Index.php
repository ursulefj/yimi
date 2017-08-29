<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/28
 * Time: 16:41
 */
namespace app\admin\controller;

use think\Controller;
class Index extends Error {
    public function index(){
        return $this->fetch('');
    }
}