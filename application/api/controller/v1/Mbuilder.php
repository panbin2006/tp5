<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/9
 * Time: 16:35
 */

namespace app\api\controller\v1;
use app\api\model\Mbuilder as MbuilderModel;
use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\exception\MbuilderException;
use app\lib\exception\SuccessMessage;

class Mbuilder
{
    /**
     * 根据代码查找施工单位
     * @param $id
     */
    public  static  function getOne($id){

        $builder = MbuilderModel::getOne($id);

        if(!$builder){
            throw new MbuilderException();
        }

        return $builder;
    }

    /**
     * 根据 施工单位、执行状态获取分页数据
     * @param int $size  单页记录数
     * @param int $page  页码
     * @param string $name 施工单位
     * @param string $state 执行状态
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public  static  function getRecent($size=15, $page=1, $name='',$state=''){
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMbuilders = MbuilderModel::getMostRecent($size, $page, $name, $state);

        if($pageMbuilders->isEmpty()){
            return [
                'current_page' => $pageMbuilders->currentPage(),
                'data' => []
            ];
        }

        $data = $pageMbuilders->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMbuilders->currentPage(),
            'data' => $data
        ];
    }

    /**
     * 修改施工单位审核标志
     * @param $id   string 客户代码
     * @param $flag bool  审核标志
     * @return $result bool
     */
    public static function setSH($id, $flag){
        $result = MbuilderModel::upSHTag($id, $flag);
        return $result;
    }

    /**
     * 修改施工单位资料执行状态
     * * @param $id
     * @param $state
     * @return MbuilderModel
     */
    public static function setState($id, $state){
        $result = MbuilderModel::upState($id, $state);
        return $result;
    }

    /**
     * 施工单位登陆
     * @method  POST
     * @return mixed
     */
    public static function login()
    {
        $where = input('post.');
        $cust = MbuilderModel::check($where);

        if(!$cust){
            throw new MbuilderException(['msg' => '用户名或密码错误']);
        }

        return $cust;
    }

    /**
     * 新增/修改施工单位
     * @return \think\response\Json
     */
    public static function save(){

        $inputs  = input('post.');
        $data = $inputs['data'];
        $where = $inputs['where'];

        $cust = MbuilderModel::get($where);
        if(empty($cust)){

            $result = MbuilderModel::create(array_merge($data, $where));
        }else{
            //数据库表更新触发器问题，TriTag必须与原记录的值不一样，这样才不会触发更新触发器
            //不然数据更新失败
            $data['TrigTag'] = $cust->TrigTag +1;
            $result = MbuilderModel::update($data, $where);
        }


        return json(new SuccessMessage(['msg' => $result]), 201);
    }

    /**
     * 施工单位修改密码
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function edit(){
        $params = input('post.');
        $cust = MbuilderModel::where([
            'Buildid' => $params['yhid'],
            'Remark1' => $params['password'],
            'CoID' => $params['coid']
        ])->find();

        if(!$cust){
            return json(new MbuilderException(['msg'=> '旧密码不正确']), 404);
        }

        $cust->save([
            'TrigTag' => !$cust['TrigTag'],
            'Remark1' => $params['newPassword']
        ]);
        return json(new SuccessMessage(), 201);
    }
}