<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/11
 * Time: 14:57
 */

namespace app\api\controller\v1;

use app\api\model\Mbetoninfo as MbetoninfoModel;
use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;

class Mbetoninfo
{
   public static function getRecent($size=15, $page=1){

       (new Count())->goCheck($size);
       (new PageNumberMustBePositiveInt())->goCheck($page);
       $pageMbetoninfos = MbetonInfoModel::getMostRecent($size, $page);

       if($pageMbetoninfos->isEmpty()){
           return [
               'current_page' => $pageMbetoninfos->currentPage(),
               'data'   => []
           ];
       }
       $data = $pageMbetoninfos->getCollection()
           ->toArray();
       return [
           'current_page' => $pageMbetoninfos->currentPage(),
           'data'  => $data
       ];

   }


    /**
     * @url  /mbetoninfo/typelist
     * @http POST
     * @betonType   str 产品类型： 强度 grade, 特殊要求  TSName, tld 坍落度， 施工方式  BTrans
     * 根据产品类别(强度、特殊要求、施工方式、坍落度)查询
     * @return false|\PDOStatement|string|\think\Collection
     */
   public static  function getListByBetonType(){
       $params = input('post.');
       $betonType = $params['betonType'];
       $list = MbetoninfoModel::getListByBetonType($betonType);
       return $list;
   }



}