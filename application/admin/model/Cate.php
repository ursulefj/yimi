<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 14:08
 */
namespace app\admin\model;

use think\Model;
use think\Db;
class Cate extends Model{
    static public function getAllCate($n){
        //将栏目按顶级栏目排列
        $data=Db::name('cate')->order('path')->paginate($n);
//        dump($data);exit;
        $arr=$data->all();
        $page=$data->render();
//        dump($page);
//        dump($arr);exit;
        foreach($arr as $key=>$val){
            $arr[$key]['name']=str_repeat('--',$val['level']).$val['name'];
        }
        return [
            'data'=>$arr,
            'page'=>$page,
        ];
    }
    static public function getCateById($id){
        if(!$id){
            return false;
        }
        $data = db('cate')->find($id);
        return $data;
    }
    static public function topCate($data){
        $id=Db::name('cate')->insertGetId($data);
        if(!$id){
            return false;
        }
        $path=$id;
        $r=Db::name('cate')->update(
            [
                'id'=>$id,
                'path'=>$path
            ]
        );
        return $r?true:false;
    }
    static public function addCate($data){
        $arr=self::getCateById($data['id']);
        if(!$arr||empty($arr)){
            return false;
        }
        $pid=$data['id'];
        $name=$data['name'];
        $level=$arr['level']+1;
//        dump($level);exit;
        $param=[
            'pid'=>$pid,
            'name'=>$name,
            'level'=>$level
        ];
        $id=Db::name('cate')->insertGetId($param);
        if(!$id){
            return false;
        }
        $path=$arr['path'].','.$id;
        $r=Db::name('cate')->update(
            [
                'id'=>$id,
                'path'=>$path,
                'level'=>$level
            ]
            );
        return $r?true:false;
    }
    static public function add(){

    }
}