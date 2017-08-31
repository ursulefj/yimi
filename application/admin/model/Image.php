<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 15:08
 */
namespace app\admin\model;

use think\Controller;
use think\Model;
use think\Db;
class Image extends Model{
    static public function getAllImgs(){
        $data=Db::name('image')->order('goods_id')->select();
//        dump($data);exit;
        return $data;
    }
    static public function getImgs(){
        $data=Db::name('image')->order('goods_id')->paginate(4);
//        dump($data);exit;
        return $data;
    }
    static public function addImgs($id){
        $data=Db::name('goods')->order('goods_id')->find($id);
//        dump($data);exit;
        return $data;
    }
    static public function img($file){
        $file=request()->file($file);
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            $filename = '/uploads/' . $info->getSaveName();
            $filename = str_replace('\\', '/', $filename);
            $pic['image_url'] = $filename;
            return $pic['image_url'];
        } else {
            // 上传失败获取错误信息
            return false;
        }
    }
    static public function thumb($url,$width=300,$height=300){
        $image = \think\Image::open('.'.$url);
        $dir=dirname($url);
        $file=basename($url);
        $save_name=$dir.'/'.$width.'_'.$file;
// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
        $r=$image->thumb($width, $height,\think\image::THUMB_CENTER)->save('./'.$save_name);
        if(!$r){
            return false;
        }
        return$save_name;
    }
}