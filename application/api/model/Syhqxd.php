<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/12
 * Time: 10:34
 */

namespace app\api\model;


use think\Model;

class Syhqxd extends Model
{
 protected $visible = [
     'ModuleID','PRead','PAdd','PEdit','PDel','PPrint','PSH','PGZ'
 ];

}