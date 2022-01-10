<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\gps\model;


use think\Model;
//工程信息
class UEngineSites extends Model
{

    protected  $connection = 'db_gps';
    protected  $table='u_engine_sites';

    public static  function  getMostRecent($size, $page)
    {
        $u_engine_sites = self::paginate($size,false, ['page' => $page]);
        return $u_engine_sites;
    }

}