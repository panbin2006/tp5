<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/11
 * Time: 14:58
 */

namespace app\api\model;


use think\Model;

class Mbetoninfo extends  Model
{
    protected $visible = [
            "CoID",
            "Grade",
            "JSID",
            "TSID",
            "TSName",
            "tld",
            "BTrans",
            "RZ",
            "FLRZ",
            "NoteMan",
            "ExecState",
            "checked"
    ];

    //增加checked字段返回给前端，前面checkbox选择状态，默认为false
    public static function  getCheckedAttr(){
        return  false;
    }
    public  static  function  getMostRecent($size, $page){
        $mbetoninfos = self::order('Grade desc')
            ->paginate($size, ['page' => $page]);
        return $mbetoninfos;
    }

    public static  function getListByBetonType($betonType)
    {
        $list = self::where($betonType,'<>','')
            ->select();
        return $list;
    }

    public static function getGrade(){
        $gradeList = self::where('Grade','<>', '')
            ->select();
        return $gradeList;
    }
}