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

    public  static  function  getRunningMissions()
    {
        //用Db查询
       // $RunningMissions = UmissionsModel::getRunningMissions();

        //用模型方法
        $RunningMissions = UmissionsModel::getRunningMissionsByModel();
        if($RunningMissions){
            return $RunningMissions;
        }
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