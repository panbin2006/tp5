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

        $queryTime = date("Y-m-d H:i:s",time()- 60); //获取一分钱前的时间作为查询时间

//        $db  = 'NEWECOMGPS2204';
//        $table = 'gps220423';
        $dbThisMonthTrack = config('dbThisMonthTrack');
        $dbThisMonthTrack['database'] = $db;
        $connThisMonth = Db::connect($dbThisMonthTrack);

        $sql = 'select a.VehicleID as id,a.VehicleCode as content,a.GLat as  latitude,a.GLng as longitude  '.
         ' from '.$table.'   as  a inner join'.
            ' (select VehicleCode,MAX(ID) As MaxID from  '.$table.'   where GpsTime > \''.$queryTime.'\'  group by VehicleCode) as  b '.
            '  on a.VehicleCode = b.VehicleCode and a.ID = b.MaxID '.
            '  where a.GpsTime>\''.$queryTime.'\''.
            '  order by a.VehicleCode ';


        $result = $connThisMonth->query($sql);

        $connThisMonth->close();

        return $result;


    }

}