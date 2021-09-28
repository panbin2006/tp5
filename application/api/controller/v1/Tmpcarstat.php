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
    public function getRecentByCar($page=1,$size=15)
    {
        $params = input('post.');
        $searchtxt = $params['searchtxt'];
        $carid = $params['CarID'];
        $carsjxm = $params['CarSJXM'];
        $where=[];

        if($carid)
        {
            $where['CarID'] = $carid;
        }
        if($carsjxm)
        {
            $where['CarID'] = $carid;
        }
        if(!($carid||$carsjxm) && $searchtxt){ //判断客户端上传的搜索字符串
            $where['CarID|CarSJXM']= ['like','%'.$searchtxt.'%'];
        }

        $sql = "exec sp_CarStat ' and PDate >= ''".$params['PDateS']."'' and PDate <= ''".$params['PDateE']."'' and CoID = ''".$params['CoID']."''','CarStat'";
        if($page==1)
        {
            TmpCarStatModel::execProduce($sql);
        }
        $TmpcarstatList = TmpCarStatModel::getRecentByCar($size, $page, $where);

        return $TmpcarstatList;
    }

    /**
     * 车辆运输统计（按司机）
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getRecentByDriver($page=1,$size=15)
    {
        $params = input('post.');
        $searchtxt = $params['searchtxt'];
        $carid = $params['CarID'];
        $carsjxm = $params['CarSJXM'];
        $where=[];

        if($carid)
        {
            $where['CarID'] = $carid;
        }
        if($carsjxm)
        {
            $where['CarID'] = $carid;
        }
        if(!($carid||$carsjxm) && $searchtxt){ //判断客户端上传的搜索字符串
            $where['CarID|CarSJXM']= ['like','%'.$searchtxt.'%'];
        }

        $sql = "exec sp_CarStat ' and PDate >= ''".$params['PDateS']."'' and PDate <= ''".$params['PDateE']."'' and CoID = ''".$params['CoID']."''','CarStatSJ'";
        //第一次查询 ，先执行存储过程
        if($page==1)
        {
            TmpCarStatModel::execProduce($sql);
        }
        $TmpcarstatList = TmpCarStatModel::getRecentByDriver($size, $page, $where);
        return $TmpcarstatList;
    }

    /**
     * 车辆运输统计（按车号&司机）
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getRecentByCarAndDriver($page=1,$size=15)
    {
        $params = input('post.');
        $searchtxt = $params['searchtxt'];
        $carid = $params['CarID'];
        $carsjxm = $params['CarSJXM'];
        $where=[];

        if($carid)
        {
            $where['CarID'] = $carid;
        }
        if($carsjxm)
        {
            $where['CarID'] = $carid;
        }
        if(!($carid||$carsjxm) && $searchtxt){ //判断客户端上传的搜索字符串
            $where['CarID|CarSJXM']= ['like','%'.$searchtxt.'%'];
        }

        $sql = "exec sp_CarStat ' and PDate >= ''".$params['PDateS']."'' and PDate <= ''".$params['PDateE']."'' and CoID = ''".$params['CoID']."''','CarSJStat'";
        //第一次查询 ，先执行存储过程
        if($page==1)
        {
            TmpCarStatModel::execProduce($sql);
        }
        $TmpcarstatList = TmpCarStatModel::getRecentByCarAndDriver($size, $page, $where);
        return $TmpcarstatList;
    }

}