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

    public function getAveOutTimeAttr($AveOutTime){
        $AveOutTime = is_null($AveOutTime) ? 0 : $AveOutTime;
        return (int)$AveOutTime;
    }

    public function getAveWaitUnLoadTimeAttr($AveWaitUnLoadTime){  //AveWaitUnLoadTime,AveUnLoadTime,
        $AveWaitUnLoadTime = is_null($AveWaitUnLoadTime) ? 0 : $AveWaitUnLoadTime;
        return (int)$AveWaitUnLoadTime;
    }

    public function getAveUnLoadTimeAttr($AveUnLoadTime){
        $AveUnLoadTime = is_null($AveUnLoadTime) ? 0 : $AveUnLoadTime;
        return (int)$AveUnLoadTime;
    }

    public function getAveDistanceAttr($AveDistance){
        $AveDistance = is_null($AveDistance) ? 0 : $AveDistance;
        return (int)$AveDistance;
    }

    //增加“累计车次”属性
    public function getTransIndexAttr(){
        return $this->lastTask->trans_index;
    }

    //增加“累计方量”属性
    public function getAcptCountsAttr(){
        return $this->lastTask->acpt_counts;
    }

    //关联查询工程信息
    public   function enginSite(){

        return self::belongsTo('UEngineSites','compact_code','compact_code')
            ->bind('engine_name,engine_addr,service_unit,longitude,latitude,CustomerName,EngineAveDistance,GEngineSitePoints,Salesman');

    }

    //查询当前计划最后一张送货单
    public function lastTask(){
        return self::hasOne('UTasks','mis_code','mis_code')->order(' task_id desc');
    }

    //关联查询正在运输的发货
    public function tasks(){
        return self::hasMany('UTasks','mis_code','mis_code')
            ->with(['vehicle'])
            ->field(['isreturn','mis_code','vehicle_code','OutFactorySiteMileage','InEngineSiteMileage'])
            ->where('isreturn','<>','3');
    }

    /*
     * 查询正供计划方案一：计划状态
     */
    public static  function getRunningMissionsByModel()
    {
        date_default_timezone_set('Asia/Shanghai'); //设置时区
        $queryTime = date("Y-m-d",time()); //获取当前日期作为查询时间
        $missions = self::with(['enginSite'])
                 ->field('mis_code,compact_code,engine_component,require_amount,tt_aa,tt_bb,AveOutTime,AveWaitUnLoadTime,AveUnLoadTime,AveDistance')
            ->where('state_id','=','1')
            ->where('ModifyStatusTime','>',$queryTime)
            ->select();
        return $missions;
    }


}