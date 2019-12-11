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

class Mcustomer
{
    /**
     * 根据客户代码查找客户
     * @param $id
     */
    public  static  function getOne($id){
        $customer = McustomerModel::where('custid', '=', $id)
            ->find();
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

}