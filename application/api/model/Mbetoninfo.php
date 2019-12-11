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
            "ExecState"
    ];
    public  static  function  getMostRecent($size, $page){
        $mbetoninfos = self::order('Grade desc')
            ->paginate($size, ['page' => $page]);
        return $mbetoninfos;
    }
}