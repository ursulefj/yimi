<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 10:44
 */
namespace app\admin\model;

use think\Model;
use think\Db;
class Goods extends Model{
    static public function getAllGoods($n){
        $data=Db::name('goods')
            ->alias('g')
            ->join('image i','i.goods_id=g.goods_id','left')
            ->join('cate c','c.id=g.cate_id','left')
            ->field('g.goods_id,g.goods_name,g.sell_price,g.cate_id,g.freze,g.last_modify_id,g.last_time,g.is_up,i.image_url,i.is_face,c.name')
            ->paginate($n);
        return $data;
    }
    static public function getGoods($id){
        $data=Db::name('goods')
            ->alias('g')
            ->join('image i','i.goods_id=g.goods_id','left')
            ->field('g.goods_id,g.goods_name,g.sell_price,g.market_price,g.store,g.desc,g.content,g.cate_id,g.freze,g.last_modify_id,g.last_time,i.image_url,i.is_face')
            ->find($id);
        return $data;
    }
    static public function updateGoods(){

    }
}