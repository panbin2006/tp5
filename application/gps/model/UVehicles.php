<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\gps\model;


use think\Db;
use think\db\Query;
use think\Model;
use app\gps\model\UTasks;
//车辆表
class UVehicles extends Model
{

    protected  $connection = 'db_gps';
    protected  $table='u_vehicles';

    protected  $pk = 'car_code';

    protected $append = ['isreturn','percentage','aveDistance','toMileage','returnMileage','mileage',
        'outFactorySiteMileage','inEngineSiteMileage'
    ];

    //去程公里数
    public function getToMileageAttr()
    {
        $toMileage = 0;
        if($this->outFactorySiteMileage>0){
            $toMileage = bcsub($this->mileage , $this->outFactorySiteMileage,2);
            //$toMileage = $this->mileage -  $this->outFactorySiteMileage;
        }
        return $toMileage;
    }

    ////返程公里数
    public function getReturnMileageAttr()
    {
        $returnMileage = 0;
        if( $this->inEngineSiteMileage>0){
            $returnMileage = bcsub($this->mileage, $this->inEngineSiteMileage, 2);
            //$returnMileage = $this->mileage - $this->inEngineSiteMileage;
        }
        return  $returnMileage;
    }

    //当前车辆去程或回程的运行进度
    public function getPercentageAttr(){
        //车辆运行状态： 0:装料未出场  1:去程   2:回程   3:排队车辆    4:到达工地
        $percentage = 0;
        $aveDistance = $this->aveDistance;                     //工地运距
        $toMileage  = $this->toMileage;                      //去程公里数
        $returnMileage = $this->returnMileage;              //返程公里数


        if(($this->isreturn == 1) && $aveDistance<>0 ){//去程
            $percentage = bcdiv($toMileage, $aveDistance,2);
           // $percentage =  $toMileage/ $aveDistance;
        }

        if(($this->isreturn == 2) && $aveDistance<>0 ){//返程
            $percentage = bcdiv( bcsub($aveDistance , $returnMileage,2) ,$aveDistance,2);
            //$percentage = ($aveDistance - $returnMileage) / $aveDistance;
        }

        return   $percentage;
    }

    //进入工地时车辆里程
    public function getInEngineSiteMileageAttr(){
        $InEngineSiteMileage = $this->task->InEngineSiteMileage;
        return is_null($InEngineSiteMileage) ? 0 : $InEngineSiteMileage;
    }

    //出厂时车辆里程
    public function getOutFactorySiteMileageAttr(){
        $outFactorySiteMileage = $this->task->OutFactorySiteMileage;
        return is_null($outFactorySiteMileage) ? 0 : $outFactorySiteMileage;
    }

    //车辆运行状态： 0:装料未出场  1:去程   2:回程   3:排队车辆    4:到达工地
    public function getIsReturnAttr(){
        return $this->task->isreturn;
    }

    //运输距离
    public function getAveDistanceAttr(){
        $aveDistance = $this->task->AveDistance;
        return is_null($aveDistance) ? 0 : $aveDistance;
    }

    //当前公里数
    public function getMileageAttr()
    {
        $mileage = $this->xslc['Mileage'];
        return is_null($mileage) ? 0 : $mileage;
    }


    //查询待命车辆
    public static function  getWorkingVehicles(){

        $Vehicles = self::with(['xslc'=>function($query){
            $query->field(['ID','VehicleCode','Mileage','ModifyTime']);
        },'task'=>function($query){
            $query->field(['task_id', 'task_code', 'task_oldcode', 'mis_code', 'vehicle_code', 'cur_load', 'trans_index',
            'acpt_counts', 'trans_dtime', 'driver_name', 'task_tag', 'isreturn', 'out_factory_dtime', 'in_factory_dtime', 
                'site_in_dtime', 'unburden_dtime', 'unburden_end_dtime', 'site_out_dtime', 'lc', 'lc2', 'totalLc', 
                'OutFactorySiteMileage', 'InEngineSiteMileage', 'AppendTime', 'ModifyTime', 'Inure', 'Effect', 'UnLoadCount',
            'CompleteSupplyTime', 'IsGenTempSite', 'iBak', 'DataSyncTime']);
        }])
            ->field(['id', 'vehicle_id', 'car_code', 'task_carnum', 'license_number', 'CarNumberColor', 'CarNo', 'VehicleTypeID',
        'VehicleTeamID', 'FactoryID', 'Work_Status', 'isInFactoryFlag', 'out_dtime', 'in_dtime', 'iTag', 'DeviceType', 'Note',
        'AppendTime', 'ModifyTime', 'Inure', 'Effect', 'UpdateWorkStatusTime', 'ProtocolVersion'])
        ->where('Work_Status','=','1')
        ->select();


        return $Vehicles;
    }


    //车辆当前运输任务
    public   function  task()
    {
        return self::hasOne('UTasks','vehicle_code','car_code');
    }


    //车辆行驶里程
   public  function  xslc(){
        return self::hasOne('CVehicleGps','VehicleCode','car_code');
   }


    public static  function  getMostRecent($size, $page)
    {
        $u_vehicles = self::paginate($size,false, ['page' => $page]);
        return $u_vehicles;
    }

    /**
     * 按车辆的工作状态、在场标志、运行状态查询
     * @param $work_status  车辆工作状态 ：1:待命  5:休息   6:检修  7:检车  8:打罐  6:租车
     * @param $isInFactoryFlag  车辆在场标志 ：0:不在场   1:在场
     * @param $isreturn  车辆运行状态： 0:装料未出场  1:去程   2:回程   3:排队车辆    4:到达工地
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static  function  getVehicles($work_status, $isInFactoryFlag,$isreturn)
    {
      $sql = 'select'.' a.vehicle_code from u_tasks as a '.
        'inner join(select vehicle_code,MAX(task_id) As MaxID from u_tasks  group by vehicle_code) as b '.
        ' on a.vehicle_code = b.vehicle_code and a.task_id = b.MaxID '.
        ' WHERE a.vehicle_code in (SELECT car_code FROM u_vehicles '.
        ' WHERE  Work_Status='.$work_status.' AND isInFactoryFlag='.$isInFactoryFlag.' )'.
        ' and a.isreturn='.$isreturn.'  order by in_factory_dtime';

        //使用原生查询默认连接database.php中配置的默认数据库，需要手动连接数据库
         $vehicles = Db::connect([
             // 数据库类型
             'type'            => 'sqlsrv',
             // 服务器地址
             'hostname'        => 'localhost',
             // 数据库名
             'database'        => 'NEWECOMSSS',
             // 用户名
             'username'        => 'DYjbzsoft',
             // 密码
             'password'        => 'DY@jbzsoft&810506',
             // 开启调试模式
             'debug'    => true,
         ])->query($sql);

      return $vehicles;
    }
}