<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/7
 * Time: 17:11
 */

namespace app\api\model;


use think\Model;

class Tmpcwiostat extends Model
{
    public $visible = [
        "CoID",
        "PLine",
        "CWID",
        "CWName",
        "CWType",
        "MatID",
        "MatName",
        "MatType",
        "Style",
        "Trademark",
        "Area",
        "ZSRate",
        "Unit",
        "NetBefore",
        "NetIn",
        "NetOutSJ",
        "NetkgR"
    ];

    public static function getMostRecent()
    {
        $tmpCWIOStats = self::where('CWName is not Null')
            ->order('CWID asc')
            ->select();

        return $tmpCWIOStats;
    }
}