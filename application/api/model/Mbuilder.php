<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/9
 * Time: 16:43
 */

namespace app\api\model;


use PDO;
use think\Model;

class Mbuilder extends Model
{

    protected $pk = 'BuildId';

    // 开启时间字段自动写入 并设置字段类型为datetime
    protected $autoWriteTimestamp = 'datetime';
    // 定义时间字段名
    protected $createTime = 'CreateTime';
    protected $updateTime = 'EditTime';

    public $visible = [
        "BuildId",
        "CoID",
        "BuildName",
        "PDate",
        "ExecState",
        "ClassID1",
        "ClassName1",
        "NoteMan",
        "Remark1",
    ];

    public static function getMostRecent($size, $page, $name, $state)
    {

        $mbuilders = self::where('Custname', 'like', '%' . $name . '%')
            ->where('ExecState', 'like', '%' . $state . '%')
            ->order('CreateTime desc')
            ->paginate($size, true, ['page' => $page]);
        return $mbuilders;
    }

    //根据客户名称查找客户
    public static function getMcustomerByCustName($buildName){
        $mcustomer = self::where('BuildName','=', $buildName)->find();
        return $mcustomer;
    }

    public static function getOne($id)
    {

        $builder = self::find($id);

        return $builder;
    }


    public static function upSHTag($id, $flag)
    {
        $result = self::where('Buildid', '=', $id)
            ->update(['SHTag' => $flag]);
        return $result;
    }


    public static function upState($id, $state)
    {
        $result = self::where('Buildid', '=', $id)
            ->update(['ExecState' => $state]);
        return $result;
    }

    public static function check($where)
    {
        $builder = self::where($where)
            ->find();

        return $builder;
    }

}