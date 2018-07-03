<?php
namespace app\index\controller;

use app\index\model\User as UserModel;

class User
{
	//新增用户方式1
	/*
	public function add(){
		$user 			= new UserModel;
		$user->nickname = '流年';
		$user->email   = 'thinkphp@qq.com';
		$user->birthday = strtotime('1977-03-05');
		if ($user->save()){
			return '用户['. $user->nickname .':' . $user->id .' ]新增成功';
		}else{
			return $user->getError();
		}
	}
	*/

	//新增用户数据2
	// public function add(){
	// 	$user['nickname'] = '看云';
	// 	$user['email'] 	  = 'kancloud@qq.com';
	// 	// $user['birthday'] = strtotime('2015-04-02');
	// 	//在usermodel中增加读取器后，简化写法
	// 	$user['birthday'] = '2015-04-02';
	// 	if($result = Usermodel::create($user)){
	// 		return '用户[' . $result->nickname . ':' . $result->id . ']新增成功';
	// 	}else{
	// 		return '新增用户失败';
	// 	}
	// }

	//通过表单新增用户数据
	public function add(){
		$user = new UserModel;
		if ($user->allowField(true)->validate(true)->save(input('post.'))){
			return '用户[' . $user->nickname . ':' . $user->id . ']新增成功';
		}else{
			return $user->getError();
		}
	}

	//批量新增用户
	public function addList(){
		$user = new UserModel;
		$list = [
			['nickname'=>'张三' , 'email'=> 'zhangshang@qq.com','birthday'=>strtotime('1988-12-01')],
			['nickname'=>'李四' , 'email'=> 'lishi@qq.com','birthday'=>strtotime('1990-11-25')]
		];
		if ($user->saveAll($list)){
			return '批量新增用户成功!'; 
		}else{
			return '批量新增用户失败！';
		}
	}

	//查询数据(返回对象，通过对象方式访问)
	// public function read($id){
	// 	$user = Usermodel::get($id);
	// 	echo $user->nickname .'<br/>';
	// 	echo $user->email .'<br/>';
	// 	// echo date('Y/m/d', $user->birthday). '<br/>';
	// 	//在usermodel中增加读取器后，简化写法
	// 	echo  $user->birthday .'<br/>';
	// 	echo  $user->user_birthday .'<br/>';
	// 	echo  $user->status.'<br/>';
	// 	echo  $user->create_time.'<br/>';
	// 	echo  $user->update_time.'<br/>';
	// 	dump($user);
	// }

	//查询数据(模型实现了ArrayAccess接口，通过数组方式访问)
	
	public function read($id){
		$user = UserModel::get($id);
		echo $user['nickname'] .'<br/>';
		echo $user['email'] .'<br/>';
		echo $user['birthday']. '<br/>';
	}
	


	//通过email查询数据
	/*
	public function readUser(){
		$user = UserModel::getbyEmail('lisi@qq.com');
		dump($user);
		echo $user->nickname .'<br/>';
		echo $user->email .'<br/>';
		echo date('Y/m/d', $user->birthday). '<br/>';
	}
	*/
	//通过nickname查询数据
	/*
	public function read(){
		$user = UserModel::get(['nickname'='流年']);
		dump($user);
		echo $user->nickname .'<br/>';
		echo $user->email .'<br/>';
		echo date('Y/m/d', $user->birthday). '<br/>';
	}
	*/


	//通过nickname查询数据,复杂查询，用查询构造器
	/*
	public function read(){
		$user = UserModel::where('nickname','流年')->find();
		dump($user);
		echo $user->nickname .'<br/>';
		echo $user->email .'<br/>';
		echo date('Y/m/d', $user->birthday). '<br/>';
	}
	*/

	// 查询多个记录
	/*
	public function index(){
		$list = Usermodel::all();
		foreach ($list as $user) {
			echo $user->nickname . '<br/>';
			echo $user->email. '<br/>';
			echo date('Y-m-d',$user->birthday) . '<br/>';
			echo '-------------------------------------------'. '<br/>';
		}
	}
	*/

	//不使用主键，可以传入数组查询 
	/*
	public function index(){
		$list = Usermodel::all(['nickname'=>'看云']);
		// $list = Usermodel::all();
		foreach ($list as $user) {
			echo $user->nickname . '<br/>';
			echo $user->email. '<br/>';
			echo date('Y-m-d',$user->birthday) . '<br/>';
			echo '-------------------------------------------'. '<br/>';
		}
	}
	*/

	//查询用户列表（查询构造器）
	/*
	public function index(){
		$list = Usermodel::where('id', '<', 3)->select();
		foreach ($list as $user) {
			echo $user->nickname . '<br/>';
			echo $user->email. '<br/>';
			echo $user->birthday. '<br/>';
			echo '-------------------------------------------'. '<br/>';
		}
	}
	*/

	//根据查询范围获取用户数据列表
	// public function index(){
	// 	$list = Usermodel::scope('email,status')->select();
	// 	foreach ($list as $user) {
	// 		echo $user->nickname . '<br/>';
	// 		echo $user->email. '<br/>';
	// 		echo $user->birthday. '<br/>';
	// 		echo $user->status. '<br/>';
	// 		echo $user->birthday. '<br/>';
	// 		echo $user->birthday. '<br/>';
	// 		echo '-------------------------------------------'. '<br/>';
	// 	}
	// }


	//支持多次调用scope方法，并且可以追加新的查询及链式操作
	public function index(){
		// $list = Usermodel::scope('email')
		// 	->scope('status')
		// 	->scope(function($query){
		// 		$query->order('id', 'desc');
		// 	})->select();

		$list = UserModel::scope('status')->select();
		foreach ($list as $user) {
			echo $user->nickname . '<br/>';
			echo $user->email. '<br/>';
			echo $user->birthday. '<br/>';
			echo $user->status. '<br/>';
			echo $user->birthday. '<br/>';
			echo $user->birthday. '<br/>';
			echo '-------------------------------------------'. '<br/>';
		}
	}

	//更新数据
	/*
	public function update($id){
		$user 			= UserModel::get($id);
		$user->nickname = '刘晨';
		$user->email    = 'liu21s@gmail.com';
		if (false !== $user->save()){
			return '更新用户成功';
		}else{
			return $user->getError();
		}
	}	
	*/

	//更新数据，更高效的方法
	public function update($id){
		$user['id'] = (int) $id;
		$user['nickname'] = '刘晨2';
		$user['email'] = 'liu21st@gmail.com';
		$result		   = userModel::update($user);
		return '更新成功！';
	}

	//删除数据
	/*
	public function delete($id){
		$user = UserModel::get($id);
		if($user){
			$user->delete();
			return '删除用户成功';
		}else{
			return '删除的用户不存在'; 
		}
	}
	*/
	//删除数据(destroy)
	public function delete($id){
		$user = UserModel::get($id);
		if($user){
			$user->delete();
			return '删除用户成功';
		}else{
			return '删除的用户不存在'; 
		}
	}


	public function create(){
		return view();
		// return view('user/create');
	}
}
?>