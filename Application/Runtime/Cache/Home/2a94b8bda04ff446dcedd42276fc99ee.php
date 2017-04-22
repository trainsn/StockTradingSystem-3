<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>股票交易系统——个人中心</title>
        <link rel="stylesheet" href="/stocktradingsystem/Public/css/bootstrap.min.css">  
    </head>

  <body id="index">
        <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" href="#" style="
    width: 430px;
">
        <img alt="Brand" class="col-sm-2 col-xs-3" src="/stocktradingsystem/Public/logo2.jpg" style="
    width: 55px;
">  
    股票交易个人中心
    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
    </a>
    </div>
    <ul class="nav navbar-nav navbar-right">
    <li><a>你好，学生<?php echo ($username); ?>，今天是<?php echo ($date); ?></a></li>
    <li><a href="javascript:ms=confirm('确定退出');ms?location.href='/stocktradingsystem/index.php/Home/Index/admin_exit':history.go(0)" class="btn btn-danger" style="
    margin-top: 6px;
    margin-left: 6px;
    margin-bottom: 6px;
    margin-right: 6px;
">退出登录</a></li>
    </ul>
   </div>
   </nav>
     <div class="container-fluid">
    <div class="col-sm-3 col-xs-5">
    <div class="list-group">
  <a href="#" class="list-group-item active">菜单</a>
  <a href="/stocktradingsystem/index.php/Home/Index/index" target="frameBord" class="list-group-item">买入</a>
  <a href="/stocktradingsystem/index.php/Home/Index/sellStock" target="frameBord" class="list-group-item">卖出</a>
  <a href="/stocktradingsystem/index.php/Home/Index/publishCourse" target="frameBord" class="list-group-item">撤单</a>
  <a href="/stocktradingsystem/index.php/Home/Index/manageCourse" target="frameBord" class="list-group-item">查询</a>
  
    </div>
   </div>
   <div class="col-sm-8 col-xs-7">
    <form class="form-horizontal" action="/stocktradingsystem/index.php/Home/Index/addCourse" method="post" name="myform" >
            <div class="form-group">
        <label class="col-sm-1 col-lg-2 control-label">股东代码</label>
        <div class="col-sm-3 col-lg-3">
        <select class="form-control" name='suit'>
           <option value="0">沪A</option>
           <option value="1">深A</option>
        </select>
      </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 col-lg-2 control-label">证券代码</label>
        <div class="col-sm-3 col-lg-3">
        <input type="text" class="form-control" name="capacity">
      </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 col-lg-2 control-label">买入价格</label>
        <div class="col-sm-3 col-lg-3">
        <input type="text" class="form-control" name="classroom">
      </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 col-lg-2 control-label">买入数量</label>
        <div class="col-sm-3 col-lg-3">
        <input type="text" class="form-control" name="classroom">
      </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-1 col-sm-5">
          <input type="submit" class="btn btn-primary" name="submit" value="发布" class="publish" onclick="check()">
          <input type="reset" class="btn btn-danger" value="清除">
        </div>
      </div>
    </form>
   </div>
 </div>
 </body>
 </html>