<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\gps\model;


use BaconQrCode\Common\Mode;
use think\Model;
//车辆里程表
class CFactorySite extends Model
{

    protected  $connection = 'db_gps';
    protected  $table='c_factorySite';

    public static  function  getList()
    {
        $c_factorySite = self::select();
        return $c_factorySite;
    }

}