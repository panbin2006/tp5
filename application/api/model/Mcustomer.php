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

class Mcustomer extends Model
{

    protected $pk = 'custid';

    public $visible = [
        "CustID",
        "CoID",
        "CustName",
        "PDate",
        "ExecState",
        "ClassID1",
        "ClassName1",
        "NoteMan",
        "KHpwd",
    ];

    public static function getMostRecent($size, $page, $name, $state)
    {

        $mcustomers = self::where('Custname', 'like', '%' . $name . '%')
            ->where('ExecState', 'like', '%' . $state . '%')
            ->order('CreateTime desc')
            ->paginate($size, true, ['page' => $page]);
        return $mcustomers;
    }

    //根据客户名称查找客户
    public static function getMcustomerByCustName($custName){
        $mcustomer = self::where('CustName','=', $custName)->find();
        return $mcustomer;
    }

    public static function getOne($id)
    {

        $cust = self::find($id);

        return $cust;
    }


    public static function upSHTag($id, $flag)
    {
        $result = self::where('CustID', '=', $id)
            ->update(['SHTag' => $flag]);
        return $result;
    }


    public static function upState($id, $state)
    {
        $result = self::where('CustID', '=', $id)
            ->update(['ExecState' => $state]);
        return $result;
    }

    public static function check($where)
    {
        $cust = self::where($where)
            ->find();

        return $cust;
    }

}