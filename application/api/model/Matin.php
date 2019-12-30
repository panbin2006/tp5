<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\api\model;


use think\Model;

class Matin extends Model
{
    protected $pk = 'ODDID';

    protected  $visible = [
            "ODDID",
            "CoID",
            "PDate",
            "MatID",
            "MatName",
            "MatType",
            "Style",
            "Price",
            "Unit",
            "SupplierID",
            "SupplierName",
            "CarID",
            "CWName",
            "CWType",
            "QualityR",
            "QualityS",
            "Quality",
            "DateIn",
            "DateOut",
            "GHMode",
            "WGrossR",
            "WGross",
            "WTareR",
            "WTare",
            "WNet",
            "WRate",
            "WErr",
            "WorkType",
            "NoteMan",
            "CreateTime",
            "EditMan",
            "EditTime",
    ];

    public static function getMostRecent($size, $page, $pdateS, $pdateE, $name){
        $matins = self::whereBetween('DateOut',[$pdateS, $pdateE])
            ->where('MatName|SupplierName|CWName', 'like', '%'.$name.'%')
//            ->fetchSql(true)
            ->paginate($size, false, ['page' => $page]);
        return $matins;
    }

    public static function getSummary($size, $page, $pdateS, $pdateE, $name){
        $summary = self::whereBetween('DateOut',[$pdateS, $pdateE])
            ->where('MatName|SupplierName|CWName', 'like', '%'.$name.'%')
            ->field(['sum(Quality)' => 'total_quality'])
            ->find();
        return $summary;
    }
}