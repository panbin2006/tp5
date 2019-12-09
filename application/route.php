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

Route::get('api/:version/mpactm/recent', 'api/:version.Mpactm/getRecent');
Route::get('api/:version/mpactm/by_name', 'api/:version.Mpactm/getMpactmsByName');
Route::get('api/:version/mpactm/by_state', 'api/:version.Mpactm/getMpactmsByState');
Route::get('api/:version/mpactm/:id', 'api/:version.Mpactm/getOne',[], ['id' => '\d+']);
Route::post('api/:version/mpactm/sh', 'api/:version.Mpactm/setSH');
Route::post('api/:version/mpactm/state', 'api/:version.Mpactm/setState');


