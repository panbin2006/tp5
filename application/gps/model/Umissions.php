<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\gps\model;


use think\Db;
use think\Model;
//任务单
class Umissions extends Model
{

    protected  $connection = 'db_gps';
    protected  $table='u_missions';
    protected  $pk = 'mis_code';

    public static  function  getMostRecent($size, $page)
    {
        $umissions = self::paginate($size,false, ['page' => $page]);
        return $umissions;
    }

    public   function enginSite(){

        return self::belongsTo('UEngineSites','compact_code','compact_code')
            ->bind('engine_name,engine_addr,service_unit,longitude,latitude,CustomerName,EngineAveDistance');
    }

    public   function tasks(){

        return self::hasMany('UTasks','mis_code','mis_code')
            ->field('mis_code,task_code,isreturn,vehicle_code,lc,lc2,totalLc')
            ->where('isreturn','<>','3');
    }

    public function  vehicles()
    {
        return self::hasManyThrough('UVehicles','UTasks','mis_code','vehicle_code');
    }

    public static  function getMission()
    {
        $mission = self::with('enginSite')->where('mis_code','=','A220111047')->select();
        return $mission;
    }

    public static  function getRunningMissionsByModel()
    {
        $misCodes = self::getRunningMissionCodes();

        $mission = self::with('tasks,enginSite')
            ->field('mis_code,compact_code,engine_component,require_amount,tt_aa,tt_bb,AveOutTime,AveWaitUnLoadTime,AveUnLoadTime,AveDistance')
            ->whereIn('mis_code',$misCodes)
            ->select();
        return $mission;
    }

    public  static  function getRunningMissions()
    {
        $sql='select ' .' e.compact_code,e.engine_name,m.mis_code,m.engine_component,m.tt_aa,m.tt_bb,
        m.require_amount,m.AveOutTime,m.AveWaitUnLoadTime,m.AveUnLoadTime,AveDistance  from u_missions as m  
    join  u_engine_sites as e
    on e.compact_code = m.compact_code
   where m.mis_code in
(select distinct(t.mis_code)from u_tasks t
  inner join(select vehicle_code,MAX(task_id) As MaxID from u_tasks group by vehicle_code) t2
on t.vehicle_code = t2.vehicle_code and t.task_id = t2.MaxID 
where t.vehicle_code in (SELECT car_code FROM u_vehicles WHERE Work_Status=1 AND isInFactoryFlag=0 ))';

        //使用原生查询默认连接database.php中配置的默认数据库，需要手动连接数据库
        $connStr = config('yitengConn');
        $missions = Db::connect($connStr)->query($sql);
        return $missions;
    }

    public  static  function getRunningMissionCodes()
    {
        $sql='select ' .' mis_code from u_missions as m  
    join  u_engine_sites as e
    on e.compact_code = m.compact_code
   where m.mis_code in
(select distinct(t.mis_code)from u_tasks t
  inner join(select vehicle_code,MAX(task_id) As MaxID from u_tasks group by vehicle_code) t2
on t.vehicle_code = t2.vehicle_code and t.task_id = t2.MaxID 
where t.vehicle_code in (SELECT car_code FROM u_vehicles WHERE Work_Status=1 AND isInFactoryFlag=0 ))';

        //使用原生查询默认连接database.php中配置的默认数据库，需要手动连接数据库
        $connStr = config('yitengConn');
        $missions = Db::connect($connStr)->query($sql);

        $mis_codes = [];
        foreach ($missions as $key => $value){
            array_push($mis_codes,$value['mis_code']);
        }
       return $mis_codes;
    }
}