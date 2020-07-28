<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/12
 * Time: 10:31
 */

namespace app\api\controller\v1;

use app\api\model\Scobm;
use app\api\model\Syhqx as SyhqxModel;
use app\api\validate\UserValidate;
use app\api\service\User as UserService;
use app\lib\exception\UserException;
use think\Request;
use think\response\Json;

class Syhqx
{
    public  static  function  getAll(){
        $users = SyhqxModel::all();
        if(!$users){
            throw  new UserException();
        }

        $users = json($users);
        return $users;
    }

    public static function  getUserById($id=1){
        $user = SyhqxModel::getUserById($id);
        if (!$user) {
            throw  new UserException();
        }

        return json($user);
    }

    public static  function  check(){
        (new UserValidate())->goCheck();
        $params = input();
        $user = UserService::checkUser($params);
        if(!$user) {
            throw new UserException();
        }
        return $user;
    }

    /**
     * 查询部门/用户二维数组
     * @url  /api/v1/users
     * @return  Array
     */
    public static function getUsers(){

        $users = Scobm::with('children')->select();
        return $users;
    }
}