<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/26
 * Time: 10:58
 */
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'username'  =>  'require|max:25|unique:manager',
        'password' =>  'require|min:6',
    ];
    protected $message = [
        'username.require'  =>  '必须有管理员名',
        'username.max'     => '名称最多不能超过25个字符',
        'username.unique'   => '名称不能重复',
        'password.require'  => '必需有密码',
        'password.min'     => '密码最少不能少于6个字符',
    ];

    protected $scene = [
        'add'   =>  ['username','password'],
        'edit'  =>  ['username'],
    ];

}