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
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use think\Db;
use think\Request;
use think\response\Json;

class Syhqx
{
    public static function edit(){
        $params = input('post.');
        $user = SyhqxModel::where([
            'YHID' => $params['yhid'],
            'Pwd' => $params['password'],
            'CoID' => $params['coid']
        ])->find();

        if(!$user){
            return json(new UserException(['msg'=> '旧密码不正确']), 404);
        }

        $user->save([
            'TrigTag' => !$user['TrigTag'],
            'Pwd' => $params['newPassword']
        ]);
        return json(new SuccessMessage(), 201);
    }


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

    //内部管理用户登陆
    public static  function  check(){
        (new UserValidate())->goCheck();
        $params = input();

        $user = UserService::checkUser($params);
        if(!$user) {
            throw new UserException();
        }
        return $user;
    }

    //业务员登录
    public static  function  checkSaleman(){
        $params = input();

        $where = [];
        $bmid = $params['bmid'];
        $yhid = $params['yhid'];
        $pwd = $params['pwd'];

        //判断客户端是否上传部门信息
        if($bmid){
            $where['bmid'] = $bmid;
        }

        $where['yhid'] = $yhid;
        $where['pwd'] = $pwd;
        $user = UserService::checkSaleman($where);
        if(!$user) {
            throw new UserException();
        }
        return $user;
    }
    /**
     * 查询部门/用户二维数组,不包含职位为业务员的用户
     * @url  /api/v1/users
     * @return  Array
     */
    public static function getUsers(){
        $bmids = \app\api\model\Syhqx::distinct(true)->column('BMID');
        $users = Scobm::with(['children'=>function($query) {
            $query
                ->field('YHID,YHName,BMID') //报错：类的属性不存在:app\api\model\Syhqx->BMID,关联预加载的时候必须带上关联外键的主键BMID
                ->whereNull('zhiwei','or')
                ->where('zhiwei','neq','业务员');
        }])
            ->where('BMID' ,'in', array_keys($bmids))
            ->select();

        return $users;
    }

    /**
     *查询用户权限表，职位为业务员的用户
     * @url  /api/v1/users
     * @return  Array
     */
    public static function getSalemans($zhiwei){

       $salemans = SyhqxModel::Where('ZhiWei','=',$zhiwei)
           ->select();
       return $salemans;
    }
}