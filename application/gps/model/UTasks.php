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

    public  function getAveDistanceAttr(){
        return $this->mission->AveDistance;
    }

    public static  function  getMostRecent($size, $page)
    {
        $u_tasks = self::paginate($size,false, ['page' => $page]);
        return $u_tasks;
    }



    /**
     * 获取最后一车送货记录
     */
    public function lastTask()
    {
        return $this->hasOne('UTasks', 'task_id','task_id')
            ->selfRelation();
    }

    public   function mission(){

        return self::belongsTo('Umissions','mis_code','mis_code')
            ->bind('AveDistance');
    }
}