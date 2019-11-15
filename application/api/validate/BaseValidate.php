<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/14
 * Time: 10:29
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * 调用父类check方法，对参数做检验
     */
    public function goCheck(){
        //获取http传入的参数
        //对这些参数做检验
        $request = Request::instance();
        $params = $request->param();
        $result = $this->check($params);
        if(!$result){
            $e = new ParameterException([
                'msg' => $this->error
            ]);

            throw $e;
        }else{
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule='', $data='', $field=''){
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
            return true;
        }
        return false;
    }

    protected  function isNotEmpty($value, $rule='', $data='', $field=''){
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }

    protected function isMobile($value){
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        }else{
            return false;
        }
    }
}