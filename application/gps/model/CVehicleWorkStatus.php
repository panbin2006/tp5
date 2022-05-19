<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2022-04-27
 * Time: 14:30
 */

namespace app\gps\model;


use think\Model;

class CVehicleWorkStatus extends Model
{

    protected  $connection = 'db_gps';
    protected  $table='c_VehicleWorkStatus';

    public function vehicles(){
        $vehicles =  self::hasMany('UVehicles','Work_Status','Value')
            ->field(['id','car_code','Work_Status']);
        return $vehicles->append([],true);
    }

    public  static  function getVehiclesByWorkStatus(){
        $vehicles = self::with(['vehicles'])->select();
        return $vehicles;
    }
}