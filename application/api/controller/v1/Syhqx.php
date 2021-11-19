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
    //验证微信绑定的手机号
    public static function checkPhoneNum()
    {
        $params = input('post.');
        $yhid = $params['yhid'];
        $wxPhoneNumber = $params['wxPhoneNumber'];
        $user = SyhqxModel::where([
            'YHID' => $yhid,
        ])->find();

        if(!$user){
            return json(new UserException(['msg'=> '没有找到【'.$yhid.'】用户' ]), 2000);
        }
        return self::comparePhoneNumber($wxPhoneNumber,$user->Remark1);
    }
    //保存微信绑定的手机号到用户表
    public static function savePhoneNum(){
        $params = input('post.');
        $yhid = $params['yhid'];
        $wxPhoneNumber = $params['wxPhoneNumber'];
        $user = SyhqxModel::where([
            'YHID' => $yhid,
        ])->find();

        if(!$user){
            return json(new UserException(['msg'=> '没有找到【'.$yhid.'】用户' ]), 2000);
        }

        if($user->Remark1){
            return self::comparePhoneNumber($wxPhoneNumber,$user->Remark1);
        }
        else
        {
            $user->save([
                'TrigTag' => !$user['TrigTag'],
                'Remark1' => $wxPhoneNumber
            ]);
            return json(new SuccessMessage(['msg'=>'保存成功！']), 201);

        }
    }

    //对比电话号码
    private static function  comparePhoneNumber($wxPhoneNumber,$userPhoneNumber)
    {
        if($wxPhoneNumber==$userPhoneNumber)
        {
            return json(new SuccessMessage(['msg'=>'匹配成功！']), 201);
        }
        else
        {
            return json(new UserException(['msg'=>'微信用户绑定的号码不匹配']), 2002);
        }
    }

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
     **/
    public static function getUsers(){
        $bmids = \app\api\model\Syhqx::distinct(true)->column('BMID');
        $users = Scobm::with(['children'=>function($query) {
            $query
                ->field('YHID,YHName,BMID')//报错：类的属性不存在:app\api\model\Syhqx->BMID,关联预加载的时候必须带上关联外键的主键BMID
                ->where('zhiwei','neq','业务员') //where语句要在whereNull之前，不然children查不出来
                ->whereNull('zhiwei','or');
        }])
            ->where('BMID' ,'in', array_keys($bmids))
//            ->fetchSql(true)
            ->select();
//        $users = Scobm::with(['children'])
//            ->where('BMID' ,'in', array_keys($bmids))
//            ->select();

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