<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/13
 * Time: 9:39
 */

namespace app\api\model;


use think\Db;
use think\Model;

class CarStatistics extends Model
{
    protected $table = 'Msaleodd';

    public $visible = [
        "SaleID",
        "CoID",
        "PDate",
        "PLine",
        "PlanID",
        "ProjectID",
        "ProjectName",
        "Space",
        "BTrans",
        "QualityGive",
        "CarNum",
        "QualityBack",
        "Quality",
        "TransNum",
        "CarID",
        "CarSJID",
        "CarSJXM",
        "QualityTrans",
        "total",
        "total_quality",
        "total_quality_trans"
    ];


    public static function getMostRecent($size, $page, $pdateS, $pdateE, $where)
    {
        $pages = self::where($where)
            ->whereBetween('Pdate', [$pdateS, $pdateE])
//            ->fetchSql(true)
            ->paginate($size, false, ['page' => $page]);
        return $pages;
    }



    public static function getGroupData($size, $page, $pdateS, $pdateE, $where, $group)
    {

        //汇总数据
        $summaryFields = [
            'Count(1)' => 'total',
            'SUM(Quality)' => 'total_quality',
            'SUM(QualityTrans)' => 'total_quality_trans'
        ];

        $fields = array_merge(explode(',', $group), $summaryFields);

//        分组查询后再分页，要用简洁模式分页，不然会报错
        $carSummary = self::where($where)
            ->whereBetween('PDate', [$pdateS, $pdateE])
            ->field($fields)
            ->group($group)
            ->paginate($size, true, ['page' => $page]);

        return $carSummary;
    }


    public static function getSummary($pdateS, $pdateE, $where){
        $summary = self::where($where)
            ->whereBetween('PDate', [$pdateS, $pdateE])
            ->field([
                'COUNT(1)' => 'total_summary_count',
                'SUM(Quality)' => 'total_summary_quality',
                'SUM(QualityTrans)' => 'total_summary_qualityTrans',
            ])
//            ->fetchSql(true)
            ->find();
        return $summary;
    }
}