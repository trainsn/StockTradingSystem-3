<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>股票交易系统</title>
        <link rel="stylesheet" href="/pro/StockTradingSystem-3/Public/css/bootstrap.min.css">
         <!-- jQuery文件 -->
        <script src="/pro/StockTradingSystem-3/Public/js/jquery-1.12.3.min.js"></script>
        <script src="/pro/StockTradingSystem-3/Public/js/vlidate.js"></script>
    </head>
    <body>
        <div class="container">
    <h2 class="col-md-offset-2" style="margin-top: 1em;"><img src="/pro/StockTradingSystem-3/Public/logo2.png" height="30px;" /> 股票交易系统</h2>
    <hr/>
    <h3 class="col-md-offset-2" style="margin-bottom: 1em;">用户注册<small>以下均为必填项</small></h3>
        <form action='/pro/StockTradingSystem-3/index.php/Home/Register/doReg' class="form-horizontal col-md-offset-1" role="form" method="post" name="myForm"  onsubmit="return validate()">
        <div class="form-group">
          <label class="control-label col-sm-2">用户名</label>
          <div class="col-sm-5">
          <input type="text" class="form-control" aria-describedby="sizing-addon1" name='username' onblur="checkUserName()">
          </div>
          <div class="col-sm-4">
            <span id="nameInfo"></span>
          </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2">密码</label>
        <div class="col-sm-5">
        <input type="password" class="form-control" aria-describedby="sizing-addon1" name="password" onblur="checkPassword()">
        </div>
        <div class="col-sm-4">
            <span id="passwordInfo"></span>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2">确认密码</label>
        <div class="col-sm-5">
        <input type="password" class="form-control" aria-describedby="sizing-addon1" name="repassword" onblur="recheckqwd()">
        </div>
        <div class="col-sm-4">
            <span id="repasswordInfo"></span>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2">邮箱</label>
        <div class="col-sm-5">
        <input type="email" class="form-control"  aria-describedby="sizing-addon1" name="email" onblur="checkemail()">
        </div>
        <div class="col-sm-4">
            <span id="emailInfo"></span>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2">手机号码</label>
        <div class="col-sm-5">
        <input type="text" class="form-control" aria-describedby="sizing-addon1" name="phone_number" onblur="checkphone()">
        </div>
        <div class="col-sm-4">
            <span id="phoneInfo"></span>
        </div>
        </div>
        <hr/>
        <button type="submit" class="btn btn-danger col-md-offset-6">注册</button>
        <button type="reset" class="btn btn-success ">重置</button>
      </form>
    </div>
    </body>
</html>