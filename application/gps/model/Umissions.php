<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\gps\model;


use think\Model;
//任务单
class Umissions extends Model
{

    protected  $connection = 'db_gps';
    protected  $table='u_missions';

    public static  function  getMostRecent($size, $page)
    {
        $umissions = self::paginate($size,false, ['page' => $page]);
        return $umissions;
    }

    public  static  function getRuningMissions()
    {
        $missions='';

        return $missions;
    }
}