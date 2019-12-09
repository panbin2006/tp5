<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/25
 * Time: 11:13
 */

namespace app\api\model;


use think\Model;

class Mpactm extends Model
{
    protected $visible = ['ProjectID','ProjectName', 'CoID', 'ProjectShort', 'CustID', 'CustName',
        'BuildName', 'BuildName', 'HTBH', 'Address', 'ClassID1', 'ClassName1', 'ClassID2',
        'ClassName2', 'ClassName3', 'ClassName4', 'ClassName5', 'ExecState', 'Space',
        'PriceMode', 'StyleMode', 'QualityMode', 'NoteMan', 'CreateTime','mpactds'];

    protected $pk = 'ProjectID';

    public  function mpactds(){
        return  $this->hasMany('Mpactd', 'ProjectID', 'ProjectID');
    }

    public static function getMostRecent($size,$page){
        $mpactms = self::order('CreateTime desc')
            ->paginate($size, true, ['page' => $page]);
        return $mpactms;
    }

    public static function getMpactsByName($size,$page,$name){
        $mpactms = self::where('ProjectName|CustName','like', '%'.$name.'%')
//            ->whereOr('CustName', 'like','%'.$name.'%')
            ->order('CreateTime desc')
            ->paginate($size, true, ['page' => $page]);
        return $mpactms;
    }

    public static function getMpactsByExecState($size,$page,$state){
        $mpactms = self::whereLike('ExecState', '%'.$state.'%')
            ->order('CreateTime desc')
            ->paginate($size, true, ['page' => $page]);
        return $mpactms;
    }

    public static function getMpactmDetail($id){
        $mpactm = self::with('mpactds')
            ->find($id);
        return $mpactm;
    }

    public  static function  upSHTag($id, $flag){
        $result = self::where('ProjectID', '=', $id)
            ->update(['SHTag' => $flag]);
        return $result;
    }

    public static function upState($id, $state){
        $result = self::where('ProjectID', '=', $id)
            ->update(['ExecState' => $state]);
        return $result;
    }
}