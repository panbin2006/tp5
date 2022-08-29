<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2021-12-24
 * Time: 15:22
 */

namespace app\gps\controller\yiteng;

use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\gps\model\Umissions as UmissionsModel;

//任务单
class Umissions
{

    //任务单分页查询
    public static function  getRecent($size,$page)
    {
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);



        $umissions = UmissionsModel::getMostRecent($size, $page);
        if (!$umissions->isEmpty()) {
            return $umissions;
        }

    }


    /**
     * 获取正供计划单
     */

    public  static  function  getRunningMissions($salesman='')
    {
        //用Db查询
       // $RunningMissions = UmissionsModel::getRunningMissions();

        //用模型方法
        $result = []; //返回值
        $RunningMissions = UmissionsModel::getRunningMissionsByModel();
        if($RunningMissions){
            if($salesman){
                foreach ($RunningMissions as $mission){
                    if($mission['Salesman']== $salesman){
                        array_push($result,$mission);
                    }
                }
            }else{
                $result = $RunningMissions;
            }
        }
        return $result;
    }

    /*
     * 查询单个计划单
     */
    public static  function getMission()
    {
//        return 'getMission';
        $mission = UmissionsModel::getMission();
        return $mission;
    }
}