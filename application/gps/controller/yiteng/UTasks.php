<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2021-12-24
 * Time: 15:22
 */

namespace app\gps\controller\yiteng;

use app\gps\model\UTasks as UTasksModel;
//发货单
class UTasks
{


    /**
     * 查询正在运输中的计划
     */
    public static  function  getTransTasks(){
        $tasks = UTasksModel::getTransTasks();
        return $tasks;
    }




}