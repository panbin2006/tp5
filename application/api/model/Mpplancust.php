<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/25
 * Time: 11:13
 */

namespace app\api\model;


use think\Model;

class Mpplancust extends Model
{
    // 开启时间字段自动写入 并设置字段类型为datetime
    protected $autoWriteTimestamp = 'datetime';
    // 定义时间字段名
    protected $createTime = 'CreateTime';
    protected $updateTime = 'EditTime';

    public  function msaleodds(){
        return  $this->hasMany('Msaleodd', 'PlanID', 'PlanName');
    }

    public static function getMostRecent($size,$page){
        $mpplancusts = self::order('OrderID desc')
            ->paginate($size, false, ['page' => $page]);
        return $mpplancusts;
    }

    public static function getInfoByName($size,$page,$name){
        $mpplancusts = self::where('ProjectName|CustName','like', '%'.$name.'%')
//            ->whereOr('CustName', 'like','%'.$name.'%')
            ->order('CreateTime desc')
            ->paginate($size, false, ['page' => $page]);
        return $mpplancusts;
    }

    public static function getInfoByOrderType($size,$page,$orderType){
        $mpplancusts = self::where('OrderType', '=',$orderType)
            ->order('CreateTime desc')
            ->paginate($size, false, ['page' => $page]);
        return $mpplancusts;
    }

    public static function getDetail($orderID){
        $mpplancusts = self::with('msaleodds')
            ->find($orderID);
        return $mpplancusts;
    }

    public  static function  upSHTag($orderID, $flag){
        $result = self::where('OrderID', '=', $orderID)
            ->update(['SHTag' => $flag]);
        return $result;
    }

    public static function upState($id, $orderType){
        $result = self::where('Order', '=', $id)
            ->update(['OrderType' => $orderType]);
        return $result;
    }
}