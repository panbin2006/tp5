<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/7
 * Time: 17:11
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Tmpcarstat extends Model
{


    /**
     * 车辆运输统计（按车号）
     * @param $sql
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getRecentByCar($size,$page, $where)
    {
        $TmpcarstatList =  self::field('CarID,sum(isnull(QualityTrans,0)) as QualityTrans,sum(isnull(TransNum,0)) as TransNum,sum(isnull(Quality,0)) as Quality,BDate,EDate,sum(isnull(WorkHour,0)) as WorkHour,sum(isnull(TransNumA,0)) as TransNumA,sum(isnull(TransNumB,0)) as TransNumB,sum(isnull(TransNumC,0)) as TransNumC,sum(isnull(QualityTransTotal,0)) as QualityTransTotal,CarClass,CarBZorWZ,ChePai')
            ->where($where)
            ->group('CarID,BDate,EDate,CarClass,CarBZorWZ,ChePai')
            ->order('CarID,BDate,EDate,CarClass,CarBZorWZ,ChePai')
            ->buildSql();

        return self::getResult($size,$page, $where,$TmpcarstatList);
    }

    /**
     * 车辆运输统计（按车号）
     * @param $sql
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getRecentByDriver($size,$page, $where)
    {

        $TmpcarstatList =  self::field('CarSJXM,sum(isnull(Quality,0)) as Quality,sum(isnull(QualityTransTotal,0)) as QualityTransTotal,sum(isnull(TransNum,0)) as TransNum,sum(isnull(TransNumA,0)) as TransNumA,sum(isnull(TransNumB,0)) as TransNumB,sum(isnull(TransNumC,0)) as TransNumC,sum(isnull(WorkHour,0)) as WorkHour,BDate,EDate,sum(isnull(MoneyTransTotal,0)) as MoneyTransTotal,sum(isnull(QualityTrans,0)) as QualityTrans,CoID')
            ->group('CarSJXM,BDate,EDate,CoID')
            ->order('CarSJXM,BDate,EDate,CoID')
            ->buildSql();

        return self::getResult($size,$page, $where,$TmpcarstatList);

    }

    /**
     * 车辆运输统计（按车号）
     * @param $sql
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getRecentByCarAndDriver($size,$page, $where)
    {
        $TmpcarstatList  = self::field('CarID,CarSJXM,sum(isnull(Quality,0)) as Quality,sum(isnull(TransNum,0)) as TransNum,sum(isnull(TransNumA,0)) as TransNumA,sum(isnull(TransNumB,0)) as TransNumB,sum(isnull(TransNumC,0)) as TransNumC,sum(isnull(QualityTransTotal,0)) as QualityTransTotal,sum(isnull(WorkHour,0)) as WorkHour,BDate,EDate,sum(isnull(MoneyTransTotal,0)) as MoneyTransTotal,sum(isnull(QualityTrans,0)) as QualityTrans,CoID')
                ->group('CarID,CarSJXM,BDate,EDate,CoID')
                ->order('CarID,CarSJXM,BDate,EDate,CoID')
                ->buildSql();
        return self::getResult($size,$page, $where,$TmpcarstatList);
    }

    public static function execProduce($sql)
    {
        Db::startTrans();
        try {
            Db::execute($sql);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
    }

    //查询汇总数据
    public static function getSummary($where)
    {
        $summary = self::where($where)
            ->field([
                'sum(TransNum)'=> 'total_transNum',
                'sum(Quality)' => 'total_quality'])
            ->find();
        return $summary;
    }

    /**
     * 修改生成的sql,再查询分页数据
     * @param $size
     * @param $page
     * @param $where
     * @param $TmpcarstatList
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getResult($size,$page, $where,$TmpcarstatList)
    {
        $TmpcarstatList = Db::table($TmpcarstatList)
            ->alias('d2')
            ->fetchSql(true)
            ->paginate($size, false, ['page' => $page]);

        //多次为 'T1' 指定了列 'ROW_NUMBER'错误，删除多余的代码
        $itemsSql = str_replace(', ROW_NUMBER() OVER ( ORDER BY rand()) AS ROW_NUMBER',' ',$TmpcarstatList->items()[0]);
//       return $itemsSql;
        //查询分页数据
        $items = Db::query($itemsSql);
        //查询分组记录数
        $total = Db::query($TmpcarstatList->total());
        $total_count =  $total[0]['tp_count'];
        $last_page = ceil($total_count / $size);

        $summary = self::getSummary($where, $TmpcarstatList);

        return [
            'current_page' => $page,
            'last_page' => $last_page,
            'total_count' => $total_count,
            'total_quality'=> $summary['total_quality'],
            'total_transNum'=> $summary['total_transNum'],
            'data' => $items
        ];
    }
}