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
    public static function getRecentByCar($sql)
    {
        Db::startTrans();
        try {
            Db::execute($sql);
            // 提交事务
            $TmpcarstatList  = self::field('CarID,sum(isnull(QualityTrans,0)) as QualityTrans,sum(isnull(TransNum,0)) as TransNum,sum(isnull(Quality,0)) as Quality,
BDate,EDate,sum(isnull(WorkHour,0)) as WorkHour,sum(isnull(TransNumA,0)) as TransNumA,sum(isnull(TransNumB,0)) as TransNumB,
sum(isnull(TransNumC,0)) as TransNumC,sum(isnull(QualityTransTotal,0)) as QualityTransTotal,CarClass,CarBZorWZ,ChePai')
                ->group('CarID,BDate,EDate,CarClass,CarBZorWZ,ChePai')
                ->select();
            Db::commit();
            return $TmpcarstatList;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
    }

    /**
     * 车辆运输统计（按车号）
     * @param $sql
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getRecentByDriver($sql)
    {
        Db::startTrans();
        try {
            Db::execute($sql);
            // 提交事务
            $TmpcarstatList  = self::field('CarSJXM,sum(isnull(Quality,0)) as Quality,sum(isnull(QualityTransTotal,0)) as QualityTransTotal,sum(isnull(TransNum,0)) as TransNum,
sum(isnull(TransNumA,0)) as TransNumA,sum(isnull(TransNumB,0)) as TransNumB,sum(isnull(TransNumC,0)) as TransNumC,sum(isnull(WorkHour,0)) as WorkHour,
BDate,EDate,sum(isnull(MoneyTransTotal,0)) as MoneyTransTotal,sum(isnull(QualityTrans,0)) as QualityTrans,CoID')
                ->group('CarSJXM,BDate,EDate,CoID')
                ->select();
            Db::commit();
            return $TmpcarstatList;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
    }

    /**
     * 车辆运输统计（按车号）
     * @param $sql
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getRecentByCarAndDriver($sql)
    {
        Db::startTrans();
        try {
            Db::execute($sql);
            // 提交事务
            $TmpcarstatList  = self::field('CarID,CarSJXM,sum(isnull(Quality,0)) as Quality,sum(isnull(TransNum,0)) as TransNum,sum(isnull(TransNumA,0)) as TransNumA,sum(isnull(TransNumB,0)) as TransNumB,
sum(isnull(TransNumC,0)) as TransNumC,sum(isnull(QualityTransTotal,0)) as QualityTransTotal,sum(isnull(WorkHour,0)) as WorkHour,
BDate,EDate,sum(isnull(MoneyTransTotal,0)) as MoneyTransTotal,sum(isnull(QualityTrans,0)) as QualityTrans,CoID')
                ->group('CarID,CarSJXM,BDate,EDate,CoID')
                ->select();
            Db::commit();
            return $TmpcarstatList;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
    }
}