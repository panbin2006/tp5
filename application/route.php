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

use think\Route;


//Route::get('api/:version/user/:id','api/:version.Syhqx/read');
Route::get('api/:version/user', 'api/:version.Syhqx/getAll');
Route::get('api/:version/user/:id', 'api/:version.Syhqx/getUserById');
Route::post('api/:version/user/check', 'api/:version.Syhqx/check');

Route::get("api/:version/banner/:id","api/:version.Banner/getBanner");


