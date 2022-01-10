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
use app\gps\model\UTasks;
//车辆表
class UVehicles extends Model
{

    protected  $connection = 'db_gps';
    protected  $table='u_vehicles';

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