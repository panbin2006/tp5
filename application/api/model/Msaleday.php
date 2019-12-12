<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/11
 * Time: 16:21
 */

namespace app\api\model;


use think\Model;

class Msaleday extends Model
{
    protected $visible= [
            "ODDID",
            "CoID",
            "PDate",
            "PlanID",
            "ProjectID" ,
            "ProjectName" ,
            "ClassID1",
            "ClassName1" ,
            "ClassID2",
            "ClassName2",
            "CustID",
            "CustName" ,
            "BuildId",
            "BuildName",
            "Grade",
            "TSID",
            "TSName",
            "tld",
            "Part",
            "BTrans",
            "Quality",
            "QualityProd",
            "TransNum",
            "PriceTotal",
            "MoneyS",
            "MoneyTrans",
            "MoneyBQTotal",
            "MoneyBQQM",
            "total_quality",
            "total_transNum"
    ];


    public static function getMostRecent($size, $page, $pdateS, $pdateE, $name){
        $msaledays = self::whereBetween('Pdate',[$pdateS,$pdateE])
            ->where('ProjectName|CustName', 'like', '%'.$name.'%')
            ->order('PlanID desc')
            ->paginate($size, false, ['page' => $page]);

        return $msaledays;

    }

    public static function getSummary($size, $page, $pdateS, $pdateE, $name){
        $msaledays = self::whereBetween('Pdate',[$pdateS,$pdateE])
            ->where('ProjectName|CustName', 'like', '%'.$name.'%')
            ->field(['sum(Quality)'=> 'total_quality', 'sum(TransNum)' => 'total_transNum'])
            ->find();
        return $msaledays;
    }
}