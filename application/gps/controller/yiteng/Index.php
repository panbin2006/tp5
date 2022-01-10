<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2021-12-24
 * Time: 15:22
 */

namespace app\gps\controller\yiteng;

use think\Db;

class index
{
   public  function  index()
   {
       //return 'yiteng GPS is success!';
       $db = Db::connect('db_gps');
       $list = $db->name("u_cards")->select();
       return $list;
   }


}