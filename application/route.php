<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// use think\Route;
// Route::rule('hello/:name', function($name){
// 	return 'Hello0,' . $name.'!';
// });

return [
    //全局变量规则定义
    '__pattern__' => [
        'name' => '\w+',
        'id' => '\d+',
        'year' =>'\d{4}',
        'month' => '\d{2}',
    ],
    'hellorequest12/:name' =>['index/hellorequest12',[],['name'=>'\w+']],
    //'hello/:name' =>'index/index/hello',
    // 'hello/[:name]$'=>['index/hello',['method'=>'get','ext'=>'html']],

    // 'hello_request/[:name]$'=>['index/hello_request',['method'=>'get','ext'=>'html']],
    
   // 'index'=>'index/index',
    // 定义闭包
    // 'hello/[:name]'=>function($name='bibao'){
    // 	return 'hello,' . $name .'!';
    // },

    //Blog路由
   // 'blog/:year/:month' => ['blog/archive',['method'=>'get'],['year'=>'\d{4}','month'=>'\d{2}']],
   // 'blog/:id' => ['blog/get',['method'=>'get'],['id'=>'\d+']],
   // 'blog/:name' =>['blog/read',['method'=> 'get'],['name'=>'\w+']],

    //Blog路由分组设置
   
// '[blog]'=>[
//    ':year/:month' => ['blog/archive',['method'=>'get'],['year'=>'\d{4}','month'=>'\d{2}']],
//    ':id' => ['blog/get',['method'=>'get'],['id'=>'\d+']],
//    ':name' =>['blog/read',['method'=> 'get'],['name'=>'\w+']],
//    ],

    //Blog路由（在__pattern__定义全局变量后的简化路由）
        // 'blog/:id' => 'blog/get',
        // 'blog/:name' => 'blog/read',
        // 'blog-<year>-<month>' => 'blog/arichive',
        

];


