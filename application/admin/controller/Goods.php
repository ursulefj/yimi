<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 10:30
 */
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Cate as CateModel;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\Image as ImageModel;
use think\Request;
class Goods extends Controller{
    public function index(){
        //显示5条商品数据
        $data=GoodsModel::getAllGoods(5);
        $this->assign('data',$data);
        return $this->fetch('list');
    }
    public function add(){
        if(request()->isPost()){
            //获取添加数据
            $data=[
                'goods_id'=>input('goods_id'),
                'goods_name'=>input('goods_name'),
                'sell_price'=>input('sell_price'),
                'market_price'=>input('market_price'),
                'cate_id'=>input('cate_id'),
                'store'=>input('store'),
                'desc'=>input('desc'),
                'content'=>input('content'),
                'last_time' => time(),
                'last_modify_id'=>session('manager')['id']
            ];


            //判断freexe状态
            if (input('freze') == 'on') {
                $data['freze'] = 1;
            } else {
                $data['freze'] = 0;
            }

            if ($_FILES['file']['tmp_name']) {
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('file');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    $filename = '/uploads/' . $info->getSaveName();
                    $filename = str_replace('\\', '/', $filename);
                    $image_url = $filename;
                } else {
                    // 上传失败获取错误信息
                    return $this->error($file->getError());
                }
            }
            $image_b_url=ImageModel::thumb($image_url,650,650);
            $image_m_url=ImageModel::thumb($image_url,240,240);
            $image_s_url=ImageModel::thumb($image_url,120,120);
            $pic=[
                'goods_id'=>input('goods_id'),
                'image_url'=>$image_url,
                'image_b_url'=>$image_b_url,
                'image_m_url'=>$image_m_url,
                'image_s_url'=>$image_s_url,
                'is_face'=> 1,
            ];
//            $file=input('file');
//            if ($_FILES['file']['tmp_name']){
//                ImageModel::img($file);
//            }else{
//                return $this->error($file->getError());
//            }
//            dump($data);exit;
            $r=db('goods')->insert($data);
//            dump($data);exit;
            $r1=db('image')->insert($pic);
//            dump($r);exit;
            if($r&&$r1){
                return $this->success('添加成功',url('Goods/index'));
            }else{
                return $this->error('添加失败');
            }
        }
        $cate = CateModel::getAllCate(100);
        $this->assign('cate', $cate);
        return $this->fetch();
    }
    public function image(){
        $data=ImageModel::getImgs();
//        dump($data);exit;
        $this->assign('data',$data);
        return $this->fetch('');
    }
    public function addImg(){
        $id=input('id');
        $data=ImageModel::addImgs($id);
        $this->assign('data',$data);
//        dump($data);exit;
        return $this->fetch('addImg');
    }
    public function doAddImg(){

        if ($_FILES['file']['tmp_name']) {
            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $filename = '/uploads/' . $info->getSaveName();
                $filename = str_replace('\\', '/', $filename);
                $image_url = $filename;
            } else {
                // 上传失败获取错误信息
                return $this->error($file->getError());
            }
        }
//        dump($pic['image_url']);exit;
        $image_b_url=ImageModel::thumb($image_url,650,650);
        $image_m_url=ImageModel::thumb($image_url,240,240);
        $image_s_url=ImageModel::thumb($image_url,120,120);
//        ump($pic);exit;
        $pic=[
            'goods_id'=>input('goods_id'),
            'image_url'=>$image_url,
            'image_b_url'=>$image_b_url,
            'image_m_url'=>$image_m_url,
            'image_s_url'=>$image_s_url,
            'is_face'=> 0,
        ];

        $r=db('image')->insert($pic);
//            dump($r);exit;
        if($r){
            return $this->success('添加成功',url('Goods/index'));
        }else{
            return $this->error('添加失败');
        }
    }
    //跳转到修改商品内容
    public function edit(){
        $id=input('id');
        $data=GoodsModel::getGoods($id);
        $this->assign('data',$data);
        $cate = db('cate')->select();
        $this->assign('cate',$cate);
        return $this->fetch('');
    }
    public function doEdit(){
        $data=[
            'goods_id'=>input('goods_id'),
            'goods_name'=>input('goods_name'),
            'sell_price'=>input('sell_price'),
            'market_price'=>input('market_price'),
            'cate_id'=>input('cate_id'),
            'store'=>input('store'),
            'desc'=>input('desc'),
            'content'=>input('content'),
            'last_time' => time(),
            'last_modify_id'=>session('manager')['id']
        ];
        $r=db('goods')->update($data);
        if($r){
            return $this->success('修改成功',url('Goods/index'));
        }else{
            return $this->error('修改成功');
        }
    }

    public function  del(){
        $data=[
            'goods_id'=>input('id'),
            'is_up'=>0
        ];
        $r = db('goods')->update($data);
        if($r){
            return $this->success('删除成功',url('Goods/index'));
        }else{
            return $this->error('删除失败');
        }
    }
    public function  revoke(){
        $data=[
            'goods_id'=>input('id'),
            'is_up'=>1
        ];
        $r = db('goods')->update($data);
        if($r){
            return $this->success('撤销成功',url('Goods/index'));
        }else{
            return $this->error('撤销失败');
        }
    }
}