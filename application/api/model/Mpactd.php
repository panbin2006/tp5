<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/28
 * Time: 16:50
 */

namespace app\api\model;


use think\Model;

class Mpactd extends  Model
{
    protected  $pk='ItemID';

    //增加checked字段返回给前端，前面checkbox选择状态，默认为false
    public static function  getCheckedAttr(){
        return  false;
    }

    public static function getGradeList($where)
    {
       return self::where($where)->field(['JSID','Grade'])->select();
    }

    public static function getTsNameList($where)
    {
        return self::where($where)->field(['TSID','TSName'])->select();
    }


}