<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2021-01-30
 * Time: 11:03
 */

namespace app\api\model;


use think\Model;

class Mphbprodd extends Model
{
    protected $append= ['defaultShow'];
    public function getVPFSJAttr($VPFSJ){
        $VPFSJ = is_null($VPFSJ) ? 0 : $VPFSJ;
        return $VPFSJ;
    }
    //增加“是否显示用量为0的仓位”属性
    public function getDefaultShowAttr($VPFSJ){
        return $this->VPFSJ>0 ? true : false;
    }
}