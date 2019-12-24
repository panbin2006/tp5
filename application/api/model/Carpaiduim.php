<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 17:10
 */

namespace app\api\model;


use think\Model;

class Carpaiduim extends Model
{
    protected $hidden = ['Iden_id','ColsLen'];

    public static function  getPaidui(){

        $paidui = self::with('paiduid')
            ->where('ODDID','>',0)
            ->select();
        return $paidui;

    }

    public  function   paiduid(){

       return $this->hasMany('Carpaiduid','ODDID','ODDID');

    }
}