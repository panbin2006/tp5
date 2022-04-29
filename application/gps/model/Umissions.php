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
    protected $append= ['transIndex','acptCounts'];

    public function getTransIndexAttr(){
        return $this->lastTask->trans_index;
    }

    public function getAcptCountsAttr(){
        return $this->lastTask->acpt_counts;
    }

    public static  function  getMostRecent($size, $page)
    {
        $umissions = self::paginate($size,false, ['page' => $page]);
        return $umissions;
    }

    public   function enginSite(){

        return self::belongsTo('UEngineSites','compact_code','compact_code')
            ->bind('engine_name,engine_addr,service_unit,longitude,latitude,CustomerName,EngineAveDistance');
    }

    public function lastTask(){
        return self::hasOne('UTasks','mis_code','mis_code')->order(' task_id desc');
    }

    public function tasks(){
        return self::hasMany('UTasks','mis_code','mis_code');
    }

    public static  function getMission()
    {
        $mission = self::with('enginSite')->where('mis_code','=','A220111047')->select();
        return $mission;
    }

    /*
     * 查询正供计划方案一：计划状态
     */
    public static  function getRunningMissionsByModel()
    {
        $mission = self::with(['enginSite','tasks'])
            ->field('mis_code,compact_code,engine_component,require_amount,tt_aa,tt_bb,AveOutTime,AveWaitUnLoadTime,AveUnLoadTime,AveDistance')
            ->where('state_id','=','1')
            ->select();
        return $mission;
    }

    /*
     * 查询正供计划方案二：通过待命车辆反查正供计划
     */
    public static  function getRunningMissionsByModel2()
    {
        $misCodes = self::getRunningMissionCodes();

        $mission = self::with('tasks,enginSite')
            ->field('mis_code,compact_code,engine_component,require_amount,tt_aa,tt_bb,AveOutTime,AveWaitUnLoadTime,AveUnLoadTime,AveDistance')
            ->whereIn('mis_code',$misCodes)
            ->select();
        return $mission;
    }

    /*
    * 查询正供计划方案三：通过sql原生查询
    */
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

    /*
    * 查询正供计划的单号
    */
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