<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 9:51
 */

namespace app\api\model;


use think\Model;

class Matsupplier extends Model
{

    protected  $pk = 'SupplierID';

    protected  $visible = [
            "SupplierID",
            "CoID",
            "SupplierName",
            "PDate",
            "Phone",
            "Fax",
            "ExecState",
            "CreateTime",
            "EditTime",
    ];

    public static function  getMostRecnet($size, $page){
        $MatSuppliers = self::paginate($size, true, ['page' => $page]);

        return $MatSuppliers;
    }
}