<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 9:20
 */

namespace app\api\model;


use think\Model;

class Matinfo extends Model
{
    protected $pk = 'MatID';

    protected $visible = [
            "MatID",
            "CoID",
            "MatName",
            "MatType",
            "Style",
            "Unit",
            "ZSRate",
            "CreateTime",
            "EditTime",
    ];

    public static function getMostRecent($size, $page){

       $matinfos = self::paginate($size, true, ['page' => $page]);

       return $matinfos;
    }
}