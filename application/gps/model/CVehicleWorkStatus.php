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
        return self::hasMany('UVehicles','Work_Status','Value')
            ->field(['id','car_code','Work_Status']);
    }

    public  static  function getVehiclesByWorkStatus(){
        $vehicles = self::with(['vehicles'=>function($query){
           // $query->field(['id','car_code','Work_Status']);
        }])->select();
        return $vehicles;
    }
}