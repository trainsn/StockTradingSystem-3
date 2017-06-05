<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>股票交易系统——个人中心</title>
        <link rel="stylesheet" href="/stocktradingsystem-3/Public/css/bootstrap.min.css">  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="/stocktradingsystem-3/Public/css/dashboard.css">
        <style type="text/css">
            .warning{
                height:34px; 
                padding: 5px;
                color: #A0A0A0;
            }
        </style>
    </head>

  <body id="index">
        <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
    <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
    <a class="navbar-brand active" href="#">
        <img alt="Brand" class="col-sm-2 col-xs-3" src="/stocktradingsystem-3/Public/logo2.png" style="width: 55px; "/>  
    股票交易个人中心
    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
    </a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav navbar-right">
    <li><a><?php echo $_SESSION['username']?>，今天是<?php echo date('Y-m-d', time())?></a></li>
    <li><a href="javascript:ms=confirm('确定退出');ms?location.href='/stocktradingsystem-3/index.php/Home/Login/logout':history.go(0)" >退出登录</a></li>
    </ul>
   </div>
   </nav>
    
    <script src="/stocktradingsystem-3/Public/js/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="/stocktradingsystem-3/Public/js/bootstrap.min.js"></script>
    <div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
    <nav class="sidenav" data-sidenav data-sidenav-toggle="#sidenav-toggle">
      <ul id="menu" class="nav nav-sidebar">
      <li>
        <a href="/stocktradingsystem-3/index.php/Home/Index/buyStock">
          <i class="fa fa-th"></i> <span>  买入</span>
        </a>
      </li>
      <li>
        <a href="/stocktradingsystem-3/index.php/Home/Index/sellStock">
          <i class="fa fa-share"></i> <span>  卖出</span>
        </a>
      </li>
      <li>
        <a href="/stocktradingsystem-3/index.php/Home/Index/revoke">
          <i class="fa fa-dashboard" aria-haspopup="true" aria-expanded="false"></i> <span>  撤单</span>
        </a>
      </li>
      <li>
        <a href="javascript:;" data-sidenav-dropdown-toggle class="active">
          <i class="fa fa-files-o"></i> <span>  查询</span>
           <span class="caret"></span>
        </a>
        <ul  class="sidenav-dropdown" data-sidenav-dropdown>
          <li><a href="/stocktradingsystem-3/index.php/Home/Index/showPersonalAccount"><i class="fa fa-circle-o"></i> 资金账户信息</a></li>
          <li><a href="/stocktradingsystem-3/index.php/Home/Index/showHoldInfo"><i class="fa fa-circle-o"></i> 持仓信息</a></li>
          <li><a href="/stocktradingsystem-3/index.php/Home/Index/showTodayDeal"><i class="fa fa-circle-o"></i> 当日成交</a></li>
          <li><a href="/stocktradingsystem-3/index.php/Home/Index/showTodayCommission"><i class="fa fa-circle-o"></i> 当日委托</a></li>
          <li><a href="/stocktradingsystem-3/index.php/Home/Index/showDeal"><i class="fa fa-circle-o"></i> 历史成交</a></li>
        </ul>
      </li>
    </ul>
    </nav>
</div>
</div>
</div>
s
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
   <div class="col-sm-12" style="boder:3px;">
    <form class="form-horizontal" action="/stocktradingsystem-3/index.php/Home/Index/addSearch" method="post" name="myform" id="myform">
      <div class="form-group">
        <label class="col-sm-6 col-lg-4 control-label">请输入股票代码或名称</label>
        <div class="col-sm-4 col-lg-4">
        <input type="text" class="form-control" id="stockid" name="stockid">
        </div>
        <div class="col-sm-4 col-lg-4">
        <input type="submit" class="btn btn-primary" name="submit" value="个股查询" class="publish">
        </div>
      </div>
    </form>
  </div>
  </div>

  <script type="text/javascript" src="/stocktradingsystem-3/Public/js/sidenav.js"></script>
  <script>$('[data-sidenav]').sidenav();</script>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="table-responsive">
    <table class="table col-sm-12 table-bordered">
    <tr>
    <td class="col-sm-7 col-md-8" style="vertical-align: middle;" />
   <div class="col-sm-12" style="boder:3px;">
    <form class="form-horizontal" action="/stocktradingsystem-3/index.php/Home/Index/addSell" method="post" name="myform" id="myform" onsubmit="return Validate();">
      <!--<div class="form-group">
        <label class="col-sm-1 col-lg-2 control-label">股东代码</label>
        <div class="col-sm-3 col-lg-3">
        <select class="form-control" name='suit'>
           <option value="0">沪A</option>
           <option value="1">深A</option>
        </select>
      </div>
      </div>-->
      <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label">证券代码</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="stockid" name="stockid" onblur="CheckStockid(this.value)">
        </div>
        <div class="col-sm-4 warning">
        <p id="stockidInfo"></p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label">卖出价格</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="commission_price" name="commission_price" onblur="CheckPrice(this.value)">
        </div>
        <div class="col-sm-4 warning">
        <p id="priceInfo"></p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label">卖出数量</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id"commission_account" name="commission_account" onblur="CheckAccount(this.value)">
        </div>
        <div class="col-sm-4 warning">
        <p id="accountInfo"></p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label">可用资金</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" name="bankroll_usable" value="<?php echo ($bankroll_usable); ?>" readonly>
      </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-1 col-sm-5">
          <input type="submit" class="btn btn-primary" name="submit" value="下单" class="publish">
          <input type="reset" class="btn btn-danger" value="清除">
        </div>
      </div>
    </form>
   </div>
 </td>
 <td class="col-sm-5 col-md-4">
    <table class="table table-condensed table-striped" style="margin-bottom:0">
    <caption style="text-align:center">行情</caption>
      <tr align="center">
        <td>卖5</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr align="center">
        <td>卖4</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr align="center">
        <td>卖3</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr align="center">
        <td>卖2</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr align="center">
        <td>卖1</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr align="center">
        <td>买1</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr align="center">
        <td>买2</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr align="center">
        <td>买3</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr align="center">
        <td>买4</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr align="center">
        <td>买5</td>
        <td>-</td>
        <td>-</td>
      </tr>
    </table>
 </td>
 </tr>
 </table>
  </div>
  </div>
  <script type="text/javascript">
    window.onload=function(){
      var item=document.getElementById("menu");
      var itemss=item.getElementsByTagName("li");
      itemss[1].className+="active";
    }
    function CheckStockid(value)
    {
      var regex = /^[0-9A-Za-z]+$/; //只包含数字和字母
      if (value.match(regex)) {
        document.getElementById('stockidInfo').innerHTML=''; 
        return true; 
      } 
      else if(value == ''){ 
        document.getElementById('stockidInfo').innerHTML="证券代码不能为空";
        return false; 
      } 
      else{
        document.getElementById('stockidInfo').innerHTML="请输入正确的证券代码";
        return false;
      }
    }

    function CheckPrice(value)
    {
      var regexPrice =  /^[1-9]\d*(\.\d+)?$/;//正数(整数+小数)  非负数:/^[+]{0,1}(\d+)$|^[+]{0,1}(\d+\.\d+)$/

      if (value.match(regexPrice)) {
        document.getElementById('priceInfo').innerHTML='';
        return true; 
      } 
      else if(value == ''){
        document.getElementById('priceInfo').innerHTML="卖出价格不能为空";
        return false; 
      }
      else{
        document.getElementById('priceInfo').innerHTML="卖出价格需要为大于0的数字";
        return false;
      }
    }

    function CheckAccount(value)
    {
      var regexPrice =  /^[1-9]\d*(\.\d+)?$/;//正数(整数+小数)  非负数:/^[+]{0,1}(\d+)$|^[+]{0,1}(\d+\.\d+)$/

      if (value.match(regexPrice)) {
        document.getElementById('accountInfo').innerHTML='';
        return true; 
      } 
      else if(value == ''){
        document.getElementById('accountInfo').innerHTML="卖出数量不能为空";
        return false; 
      }
      else{
        document.getElementById('accountInfo').innerHTML="卖出数量需要为大于0的数字";
        return false;
      }
    }

    function Validate()
    {
      var checkStockid = CheckStockid(myform.stockid.value);
      var checkPrice = CheckPrice(myform.commission_price.value);
      var checkAccount = CheckAccount(myform.commission_account.value);
      
      if(checkStockid==true && checkPrice==true && checkAccount==true)
        return true;
      else
        return false;
    }
  </script>
 </body>
 </html>