<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2022-04-06
 * Time: 11:37
 */

namespace app\gps\controller\yiteng;



use think\Model;
use think\Db;

class VehiclesGPS
{
    public static function getVehiclesGPS(){
         date_default_timezone_set('Asia/Shanghai'); //设置时区
        $db =  'NEWECOMGPS'.substr(date('Ym'),2);
        $table = 'gps'.substr(date('Ymd'),2);

        $dbThisMonthTrack = config('dbThisMonthTrack');
        $dbThisMonthTrack['database'] = $db;
        $connLastMonth = Db::connect($dbThisMonthTrack);

        $sql = 'select a.VehicleID as id,a.VehicleCode as content,a.GLat as  latitude,a.GLng as longitude  '.
         ' from '.$table.'   as  a inner join'.
            ' (select VehicleCode,MAX(ID) As MaxID from  '.$table.'  group by VehicleCode) as  b '.
            ' on a.VehicleCode = b.VehicleCode and a.ID = b.MaxID '.
            ' order by a.VehicleCode ';


        $result = $connLastMonth->query($sql);

        return $result;

    }

}