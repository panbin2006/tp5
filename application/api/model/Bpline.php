<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\api\model;


use think\Model;

class Bpline extends Model
{
    protected $pk = 'Pline';


    protected  $visible = [
            "Pline",
            "COID",
            "PhbIDName",
            "LEDView",
            "QualityPC",
            "PlineName"
    ];

    //增加plinename字段返回给前端，生产线号：pline.'线'
    public static function  getPlineNameAttr($value,$data){
        return  $data['Pline'].'_线';
    }
    public static function getMostRecent(){
        $bplines = self::all();
        return $bplines;
    }

}