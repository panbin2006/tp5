<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 9:51
 */

namespace app\api\controller\v1;

use app\api\model\Matsupplier as MatsupplierModel;
class Matsupplier
{
    /**
     * 分页显示供应商资料
     * @param int $size 每页显示记录数
     * @param int $page 页码
     * @return \think\Paginator
     */
    public static  function getRecent($size=15, $page=1){

        $pageMatsuppliers = MatsupplierModel::getMostRecnet($size, $page);

        return $pageMatsuppliers;

    }
}