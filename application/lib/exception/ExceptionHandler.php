<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/14
 * Time: 13:37
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends  Handle
{
    private  $code;
    private  $msg;
    private  $errorCode;

    //需要返回当前请求的URL路径

    public function render(\Exception $e){
        if($e instanceof BaseException){
            //如果是自定义的异常
            $this->errorCode = $e->errorCode;
            $this->msg = $e->msg;
            $this->code = $e->code;
        }else{
            if(config('app_debug')){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->msg = '服务器内部错误';
                $this->errorCode = 900;
                $this->recordErrorLog($e);
            }
        }

        $request = Request::instance();

        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url()
        ];
        return json($result, $this->code);
    }


    private function recordErrorLog(\Exception $e){
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);

        Log::record($e->getMessage(), 'error');
    }
}