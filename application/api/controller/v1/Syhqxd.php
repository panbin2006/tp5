<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/12
 * Time: 10:31
 */

namespace app\api\controller\v1;


class Syhqxd
{
    /**
     * 获取用户权限
     */
    public static function getSingleScope(){
        $inputs = input('post.');
        $user_id = $inputs['yhid'];
        $models = $inputs['moduleid'];

        $where['ModuleID'] = $models;
        $where['YHID'] = $user_id;

        $scopes = \app\api\model\Syhqxd::where($where)
            ->find();
        return $scopes;
    }
}