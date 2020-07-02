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
//    protected $visible = ['ProjectID','ProjectName', 'CoID', 'ProjectShort', 'CustID', 'CustName',
//        'BuildName', 'BuildName', 'HTBH', 'QualityOrder','QualityGive','Address', 'ClassID1', 'ClassName1', 'ClassID2',
//        'ClassName2', 'ClassName3', 'ClassName4', 'ClassName5', 'ExecState', 'Space',
//        'PriceMode', 'StyleMode', 'QualityMode', 'NoteMan', 'CreateTime','mpactds'];
//
//    protected $pk = 'ProjectID';

    public  function msaleodds(){
        return  $this->hasMany('Msaleodd', 'PlanID', 'PlanID');
    }

    public static function getMostRecent($size,$page){
        $mpplancusts = self::order('CreateTime desc')
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

    public static function getInfoByExecState($size,$page,$state){
        $mpplancusts = self::whereLike('ExecState', '%'.$state.'%')
            ->order('CreateTime desc')
            ->paginate($size, false, ['page' => $page]);
        return $mpplancusts;
    }

    public static function getDetail($id){
        $mpplancusts = self::with('msaleodds')
            ->find($id);
        return $mpplancusts;
    }

    public  static function  upSHTag($id, $flag){
        $result = self::where('PlanID', '=', $id)
            ->update(['SHTag' => $flag]);
        return $result;
    }

    public static function upState($id, $state){
        $result = self::where('PlanID', '=', $id)
            ->update(['ExecState' => $state]);
        return $result;
    }
}