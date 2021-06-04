<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/7
 * Time: 17:11
 */

namespace app\api\model;


use think\Model;

class Tmpcwiostat2 extends Model
{
//    public $visible = [
//        "CoID",
//        "PLine",
//        "CWID",
//        "CWName",
//        "CWType",
//        "MatID",
//        "MatName",
//        "MatType",
//        "Style",
//        "Trademark",
//        "Area",
//        "ZSRate",
//        "Unit",
//        "NetBefore",
//        "NetIn",
//        "NetOutSJ",
//        "NetkgR"
//    ];

    public static function getMostRecent()
    {
        $tmpCWIOStats = self::where('CWName is not Null')
            ->field(["CoID", "PLine", "CWID", "CWName", "CWType", "MatID", "MatName",
            "MatType", "Style", "Trademark", "Area", "ZSRate", "Unit", "NetBefore", "NetIn",
                "NetOutSJ", "NetkgR"])
            ->where('MatName is not Null')
            ->order('CWType asc')
            ->select();

        return $tmpCWIOStats;
    }

    public static function getMatStoreiostatRecent()
    {
//        $tmpCWIOStats = self::all();
        $tmpCWIOStats = self::where('StoreID is not Null')
            ->where('MatName is not Null')
            ->field(['PLine','StoreID','StoreName','StoreType','MatID','MatName','NetIn','NetOutSJ',
                'StoreMax','NetkgR','StoreWarn','StoreRate',"Bdate","Edate"])
            ->order('PLine,StoreID asc')
            ->select();

        return $tmpCWIOStats;
    }
}