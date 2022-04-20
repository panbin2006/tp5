<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2022-03-22
 * Time: 16:34
 */

namespace app\gps\controller\yiteng;

use app\gps\model\CFactorySite as CFactorySiteModel;

class CFactorySite
{
    public   static  function getList(){
        $c_factorySite = CFactorySiteModel::getList();
        return $c_factorySite;
    }

}