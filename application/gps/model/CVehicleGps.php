<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\gps\model;


use think\Model;
//车辆里程表
class CVehicleGps extends Model
{

    protected  $connection = 'db_gps';
    protected  $table='c_VehicleGps';

    public static  function  getMostRecent($size, $page)
    {
        $c_vehicle_gps = self::paginate($size,false, ['page' => $page]);
        return $c_vehicle_gps;
    }

}