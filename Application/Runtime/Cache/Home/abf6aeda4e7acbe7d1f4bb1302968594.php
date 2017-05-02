<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>股票交易系统</title>
        <link rel="stylesheet" href="/stocktradingsystem-3/Public/css/bootstrap.min.css">
	</head>
	<body>
		<div class="panel panel-primary col-md-offset-2 col-xs-10 col-md-8" style="margin-top: 5%;">
		<div class="panel-heading">用户注册</div>
		<div class="panel-body">
		<form action='/stocktradingsystem-3/index.php/Home/Register/doReg' class="form-horizontal" role="form" method="post" name='myForm' >
        <div class="form-group">
          <label class="control-label col-sm-2">用户名</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" aria-describedby="sizing-addon1" name='username'>
          </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2">密码</label>
        <div class="col-sm-9">
        <input type="password" class="form-control" aria-describedby="sizing-addon1" name="password">
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2">确认密码</label>
        <div class="col-sm-9">
        <input type="password" class="form-control" aria-describedby="sizing-addon1" name="repassword">
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2">邮箱</label>
        <div class="col-sm-9">
        <input type="email" class="form-control"  aria-describedby="sizing-addon1" name="email">
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2">手机号码</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" aria-describedby="sizing-addon1" name="phone_number">
        </div>
        </div>
        <hr/>
        <button type="submit" class="btn btn-danger col-md-offset-9">注册</button>
        <button type="reset" class="btn btn-success ">重置</button>
      </form>
      </div>
      </div>
   	</body>
</html>