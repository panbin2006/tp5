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

}