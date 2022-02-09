<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2021-12-24
 * Time: 15:22
 */

namespace app\gps\controller\yiteng;

use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\gps\model\UVehicles as UVehiclesModel;

//车辆资料
class UVehicles
{
    /**
     *
     * 获取车辆的最后一条发货单
     */
    public static  function getLastTasks()
    {
        $tasks = UVehiclesModel::getLastTasks();
        return $tasks;
    }

    public  static function index()
    {
        return 'index';
    }
    //车辆分页查询
    public static function  getRecent($size,$page)
    {
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);

        $vehicles = UVehiclesModel::getMostRecent($size, $page);
        if (!$vehicles->isEmpty()) {
            return $vehicles;
        }

    }

    //查询排队车辆列表
    public static function  getQueueVehicles()
    {
        //work_status  车辆工作状态 ：1:待命  5:休息   6:检修  7:检车  8:打罐  6:租车
        // isInFactoryFlag  车辆在场标志 ：0:不在场   1:在场
        // isreturn  车辆运行状态： 0:装料未出场  1:去程   2:回程   3:排队车辆    4:到达工地
        $queueVehicles = UVehiclesModel::getVehicles(1,1,3);
        if ($queueVehicles) {
            return $queueVehicles;
        }

    }

    //查询回程车辆列表
    public static function  getReturnVehicles()
    {
        //work_status  车辆工作状态 ：1:待命  5:休息   6:检修  7:检车  8:打罐  6:租车
        // isInFactoryFlag  车辆在场标志 ：0:不在场   1:在场
        // isreturn  车辆运行状态： 0:装料未出场  1:去程   2:回程   3:排队车辆    4:到达工地
        $returnVehicles = UVehiclesModel::getVehicles(1,0,2);
        if ($returnVehicles) {
            return $returnVehicles;
        }

    }


}