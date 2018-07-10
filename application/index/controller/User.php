<?php
namespace app\index\controller;

use app\index\model\User as UserModel;
use app\index\model\Profile;
use app\index\model\Book;
use app\index\model\Role;

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
	/*
	public function add(){
		$user = new UserModel;
		if ($user->allowField(true)->validate(true)->save(input('post.'))){
			return '用户[' . $user->nickname . ':' . $user->id . ']新增成功';
		}else{
			return $user->getError();
		}
	}*/

	//控制器验证
	// public function add(){
	// 	$data = input('post.');
	// 	//数据验证
	// 	$result = $this->validate($data,'User');
	// 	if(true !== $result){
	// 		return $result;
	// 	}
	// 	$user = new UserModel;
	// 	//保存数据
	// 	$user->allowField(true)->save($data)
	// 	return '用户[' . $user->nickname . ':' . $user->id .']新增成功';
	// }

	//关联新增数据(one to one)
	/*
	public function add(){
		$user           = new UserModel;
		$user->name     = 'thinkphp';
		$user->password = '123456';
		$user->nickname = '流年';
		if ($user->save()) {
			//写入关联数据
			// $profile		   = new Profile;
			// $profile->truename = '刘晨';
			// $profile->birthday = '1977-03-05';
			// $profile->address  = '中国上海';
			// $profile->email    = 'thinkphp@qq.com';
			// $user->profile()->save($profile);
			// return '用户新增成功';

			// 写入关联数据
			$profile['truename'] = '刘晨';
			$profile['birthday'] = '1977-03-05';
			$profile['address'] = '中国上海';
			$profile['email'] = 'thinkphp@qq.com';
			$user->profile()->save($profile);
			return '用户[ ' . $user->name . ' ]新增成功';
		} else {
			return $user->getError();
		}
	}*/

	//关联新增(one to many)
	/*
	public function addBook(){
		$user 				= UserModel::get(2);
		$book 				= new Book;
		$book->title 		= 'ThinkPHP5快速入门';
		$book->publish_time = '2016-05-06';
		$user->books()->save($book);
		return '添加Book成功';
	}*/

	// 关联新增数据(many to many)
	/*
	public function add(){
		$user = UserModel::getByNickname('张三');
		//新增用户角色 并自动写入枢纽表
		$user->roles()->save(['name' => 'editor','title' => '编辑']);
		return '用户角色新增成功';
	}*/

	// 关联新增批量数据（many to many）
	/*
	public function add(){
		$user = UserModel::getByNickname('张三');
		// 给当前用户新增多个用户角色
		$user->roles()->saveAll([
			['name' => 'leader', 'title' => '领导'],
			['name' => 'admin', 'title' => '管理员'],
		]);
		return '用户角色新增成功';
	}*/

	// 关联新增（many to many）,给当前用户增加角色
	/*
	public function add(){
		$user = UserModel::getByNickname('张三');
		$role = Role::getByName('admin');
		//添加枢纽表数据
		$user->roles()->attach($role);
		return '用户角色添加成功';
	}*/


	// 关联新增（many to many）,给当前用户增加角色
	public function add(){
		$user = UserModel::getByNickname('张三');
		//添加枢纽表数据,根据id号添加
		$user->roles()->attach(2);
		return '用户角色添加成功';
	}
	//关联批量新增(one to many)
	public function addBooks(){
		$user = UserModel::get(2);
		$books = [
			['title' => 'ThinkPHP5开发手册', 'publish_time' => '2016-05-06'],
			['title' => 'ThinkPHP5路由开发', 'publish_time' => '2016-03-06'],
		];
		$user->books()->saveAll($books);
		return '添加Books成功';
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
	/*
	public function read($id){
		$user = UserModel::get($id);
		echo $user['nickname'] .'<br/>';
		echo $user['email'] .'<br/>';
		echo $user['birthday']. '<br/>';
	}
	*/

	//关联查询(一对一)
	/*
	public function read($id){
		//get方法使用第二个参数就表示进行关联预载入查询,以提高查询性能。
		// $user = UserModel::get($id,'profile');
		$user = UserModel::get($id);
		echo $user->name. '<br/>';
		echo $user->nickname. '<br/>';
		echo $user->profile->truename. '<br/>';
		echo $user->profile->email. '<br/>';
	}
	*/

	// 关联查询（一对多）
	/*
	public function read($id){
		$user  = UserModel::get($id);
		$books = $user->books;
		dump($books);
	}*/

	// 关联查询（一对多）,使用预载入查询
	/*
	public function read($id){
		$user  = UserModel::get($id, 'books');
		$books = $user->books;
		dump($books);
	}
	*/

	//关联查询(一对多)
	/*
	public function  read($id){
		$user  = UserModel::get($id);
		// 获取状态为1的关联数据
		$books = $user->books()->where('status',1)->select();
		dump($books);
		// 获取作者的某本书
		$book = $user->books()->getByTitle('ThinkPHP5快速入门');
		dump($book);
	}*/

	//关联查询（多对多）
	public function read(){
		$user = UserModel::getByNickname('张三');
		dump($user->roles);
	}

	//关联查询(根据关联数据来查询当前模型数据)
	/*
	public function read(){
		// 查询有写过书的作者列表
		$user = UserModel::has('books')->select();
		// 查询写过三本书以上的作者
		$user = UserModel::has('books','>=',3)->select();	
		// 查询写过ThinkPHP5快速入门的作者
		$user = UserModel::hasWhere('books',['title' => 'ThinkPHP5快速入门'])->select();
	}*/



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
	/*
	public function update($id){
		$user['id'] = (int) $id;
		$user['nickname'] = '刘晨2';
		$user['email'] = 'liu21st@gmail.com';
		$result		   = userModel::update($user);
		return '更新成功！';
	}
	*/

	//关联更新(一对一)
	/*
	public function update($id){
		$user 		= UserModel::get($id);
		$user->name = 'framework';
		if ($user->save()) {
			//更新关联数据
			$user->profile->email = 'liu21st@gmail.com';
			$user->profile->save();
			return '用户[' . $user->name . ']更新成功';
		} else {
			return $user->getError();
		}
	}*/

	// 关联更新（一对多）
	/*
	public function update($id){
		$user        = UserModel::get($id);
		$book 		 = $user->books()->getByTitle('ThinkPHP5开发手册');
		$book->title = 'ThinkPHP5快速入门';
		$book->save();
		echo '数据更新成功！';
	}*/

	// 使用查询构建器的 update 方法进行更新
	public function update($id){
		$user        = UserModel::get($id);
		$user->books()->where('title', 'ThinkPHP5开发手册')->update(['title' => 'ThinkPHP5开发手册PDF']);
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

	// 关联删除（一对多）
	/*
	public function delete($id){
		$user = UserModel::get($id);
		if($user->delete()){
			//删除关联数据
			$user->profile->delete();
			return '用户[' . $user->name . ']删除成功';
		} else {
			return $user->getError();
		}
	}*/

	// 关联删除（一对多）
	/*
	public function delete($id){
		$user = UserModel::get($id);
		// 删除部分关联数据
		$book = $user->books()->getByTitle('ThinkPHP5开发手册');
		$book->delete();
	}*/

	// 关联删除（一对多），删除所有的关联数据
	/*
	public function delete($id){
		$user = UserModel::get($id);
		if($user->delete()){
			// 删除所有关联数据
			$user->books()->delete();
		}
	}*/

	// 关联删除（多对多）
	/*
	public function delete(){
		$user = UserModel::getByNickname('张三');
		$role = Role::getByName('admin');
		// 删除关联数据 但不删除关联模型数据
		$user->roles()->detach($role);
	}*/

	// 关联删除(多对多)，删除枢纽表，同时删除role
	public function delete(){
		$user = UserModel::getByNickname('张三');
		$role = Role::getByName('editor');
		// 删除关联数据 并同时删除关联模型数据
		$user->roles()->detach($role,true);
		return '用户角色删除成功';
	}


	public function create(){
		return view();
		// return view('user/create');
	}
}
?>