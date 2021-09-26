<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/4
 * Time: 16:56
 */

namespace app\api\controller\v1;

use app\api\model\Tmpcarstat as TmpCarStatModel;

class Tmpcarstat
{
    /**
     * 车辆运输统计（按车号）
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getRecentByCar()
    {
        $params = input('post.');
        $sql = "exec sp_CarStat ' and PDate >= ''".$params['PDateS']."'' and PDate <= ''".$params['PDateE']."'' and CoID = ''".$params['CoID']."''','CarStat'";
//       return $sql;

        $TmpcarstatList = TmpCarStatModel::getRecentByCar($sql);
        return $TmpcarstatList;
    }

    /**
     * 车辆运输统计（按司机）
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getRecentByDriver()
    {
        $params = input('post.');
        $sql = "exec sp_CarStat ' and PDate >= ''".$params['PDateS']."'' and PDate <= ''".$params['PDateE']."'' and CoID = ''".$params['CoID']."''','CarStatSJ'";
//       return $sql;

        $TmpcarstatList = TmpCarStatModel::getRecentByDriver($sql);
        return $TmpcarstatList;
    }

    /**
     * 车辆运输统计（按车号&司机）
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getRecentByCarAndDriver()
    {
        $params = input('post.');
        $sql = "exec sp_CarStat ' and PDate >= ''".$params['PDateS']."'' and PDate <= ''".$params['PDateE']."'' and CoID = ''".$params['CoID']."''','CarSJStat'";
//       return $sql;

        $TmpcarstatList = TmpCarStatModel::getRecentByCarAndDriver($sql);
        return $TmpcarstatList;
    }

}