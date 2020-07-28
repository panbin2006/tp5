<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\api\model;


use think\Model;
//区域
class Scobm extends Model
{
    protected  $visible = ['BMID','BMName','children'];
   public  function children(){
       return $this->hasMany('Syhqx','BMID','BMID');
   }

}