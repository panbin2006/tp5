<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2022-04-06
 * Time: 11:37
 */

namespace app\gps\controller\yiteng;



use think\Db;

class VehiclesGPS
{
    public static function getVehiclesGPS(){
        $sql = 'select a.VehicleID as id,a.VehicleCode as content,a.GLat as  latitude,a.GLng as longitude  from'.'  [gps211228] as  a inner join'.
' (select VehicleCode,MAX(ID) As MaxID from [gps211228] group by VehicleCode) as  b '.
            ' on a.VehicleCode = b.VehicleCode and a.ID = b.MaxID '.
' order by a.ID ';

        //使用原生查询默认连接database.php中配置的默认数据库，需要手动连接数据库
        $vehiclesGPS = Db::connect([
            // 数据库类型
            'type'            => 'sqlsrv',
            // 服务器地址
            'hostname'        => 'localhost',
            // 数据库名
            'database'        => 'NEWECOMGPS2112',
            // 用户名
            'username'        => 'DYjbzsoft',
            // 密码
            'password'        => 'DY@jbzsoft&810506',
            // 开启调试模式
            'debug'    => true,
        ])->query($sql);

        return $vehiclesGPS;
    }

}