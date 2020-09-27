<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/9
 * Time: 16:35
 */

namespace app\api\controller\v1;
use app\api\model\Mcustomer as McustomerModel;
use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\exception\McustomerException;
use app\lib\exception\SuccessMessage;

class Mcustomer
{
    /**
     * 根据客户代码查找客户
     * @param $id
     */
    public  static  function getOne($id){

        $customer = McustomerModel::getOne($id);

        if(!$customer){
            throw new McustomerException();
        }

        return $customer;
    }

    /**
     * 根据 客户名称、执行状态获取分页数据
     * @param int $size  单页记录数
     * @param int $page  页码
     * @param string $name 客户名称
     * @param string $state 执行状态
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public  static  function getRecent($size=15, $page=1, $name='',$state=''){
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMcustomers = McustomerModel::getMostRecent($size, $page, $name, $state);

        if($pageMcustomers->isEmpty()){
            return [
                'current_page' => $pageMcustomers->currentPage(),
                'data' => []
            ];
        }

        $data = $pageMcustomers->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMcustomers->currentPage(),
            'data' => $data
        ];
    }

    /**
     * 修改客户资料审核标志
     * @param $id   string 客户代码
     * @param $flag bool  审核标志
     * @return $result bool
     */
    public static function setSH($id, $flag){
        $result = McustomerModel::upSHTag($id, $flag);
        return $result;
    }

    /**
     * 修改客户资料执行状态
     * * @param $id
     * @param $state
     * @return McustomerModel
     */
    public static function setState($id, $state){
        $result = McustomerModel::upState($id, $state);
        return $result;
    }

    /**
     * 客户登陆
     * @method  POST
     * @return mixed
     */
    public static function login()
    {
        $where = input('post.');
        $cust = McustomerModel::check($where);

        if(!$cust){
            throw new McustomerException(['msg' => '用户名或密码错误']);
        }

        return $cust;
    }

    /**
     * 新增/修改客户
     * @return \think\response\Json
     */
    public static function save(){

        $inputs  = input('post.');
        $data = $inputs['data'];
        $where = $inputs['where'];

        $cust = McustomerModel::get($where);
        if(empty($cust)){

            $result = McustomerModel::create(array_merge($data, $where));
        }else{
            //数据库表更新触发器问题，TriTag必须与原记录的值不一样，这样才不会触发更新触发器
            //不然数据更新失败
            $data['TrigTag'] = $cust->TrigTag +1;
            $result = McustomerModel::update($data, $where);
        }


        return json(new SuccessMessage(['msg' => $result]), 201);
    }

    public static function edit(){
        $params = input('post.');
        $cust = McustomerModel::where([
            'CustID' => $params['yhid'],
            'KHpwd' => $params['password'],
            'CoID' => $params['coid']
        ])->find();

        if(!$cust){
            return json(new McustomerException(['msg'=> '旧密码不正确']), 404);
        }

        $cust->save([
            'TrigTag' => !$cust['TrigTag'],
            'KHpwd' => $params['newPassword']
        ]);
        return json(new SuccessMessage(), 201);
    }
}