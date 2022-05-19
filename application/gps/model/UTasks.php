<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\gps\model;


use think\Model;
//发货单
class  UTasks extends Model
{

    protected  $connection = 'db_gps';
    protected  $table='u_tasks';
    protected  $append=['AveDistance'];



    public static  function getTransTasks(){
        date_default_timezone_set('Asia/Shanghai'); //设置时区
        $queryTime = date("Y-m-d H:i:s",time()-28800); //获取当前日期作为查询时间

        $tasks = self::where('trans_dtime','>',$queryTime)
            ->field(['task_id', 'task_code', 'task_oldcode', 'mis_code', 'vehicle_code', 'cur_load', 'trans_index',
                'acpt_counts', 'trans_dtime', 'driver_name', 'task_tag', 'isreturn', 'out_factory_dtime', 'in_factory_dtime',
                'site_in_dtime', 'unburden_dtime', 'unburden_end_dtime', 'site_out_dtime', 'lc', 'lc2', 'totalLc',
                'OutFactorySiteMileage', 'InEngineSiteMileage', 'AppendTime', 'CompleteSupplyTime'])
            ->where('isreturn','<>','3')
            ->select();
        return $tasks;
    }

    public  function getAveDistanceAttr(){
        return $this->mission->AveDistance;
    }


    /**
     * 获取最后一车送货记录
     */
    public function lastTask()
    {
        return $this->hasOne('UTasks', 'task_id','task_id')
            ->selfRelation();
    }


    public function vehicle(){
        return $this->belongsTo('UVehicles','vehicle_code','car_code')
            ->field(['car_code']);
    }

    public   function mission(){

        return self::belongsTo('Umissions','mis_code','mis_code')
            ->bind('AveDistance');
    }


}