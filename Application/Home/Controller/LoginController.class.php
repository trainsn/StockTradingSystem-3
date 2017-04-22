<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	function login(){	// 登录模块
		$this->display();
	}

	function check_login()
	{
		session_start();
		$user = M('User');
		$condition['username'] = $_POST['username'];
		$us = $user->where($condition)->find();
		if (!$us){
			$this->error("用户名不存在");
		}
		if ($us['password']!=$_POST['password']){
			$this->error("密码错误");
		}
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['userid'] = $us['userid'];
		$this->success("登录成功",U('Index/index'));
	}

	function check_logined(){	//检测是否已经登录
		session_start();
		$user =  M('user');
		$condition['username']  = $_SESSION['username'];
		$us = $user->where($condition)->find();
		if (!$us){
			$url = U('login');
			$this->assign("jumpUrl",$url);
			$this->error("还没有登录");
		}
	}

	function logout(){	 //注销
		$_SESSION=array();
		if(isset($_COOKIE[session_name()])){
			setcookie(session_name(),'',time()-1,'/');
		}
		session_destroy();
		$this->redirect('Index/index');
	}
}