<?php
namespace Home\Controller;
use Think\Controller;
class RegisterController extends Controller {
	function reg(){	// 注册模块
		$this->display();
	}

	function doReg(){	//注册写数据库
		$user = D('user');
		if (!$user->create()){
			$this->error($user->getError());
		}

		$lastId = $user->add();
		if ($lastId){
			$this->redirect('Index/index');
		}else {
			$this->error("用户注册失败");
		}
	}
}