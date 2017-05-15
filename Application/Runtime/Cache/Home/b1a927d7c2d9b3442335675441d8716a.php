<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>股票交易系统——个人中心</title>
        <link rel="stylesheet" href="/stocktradingsystem-3/Public/css/bootstrap.min.css">  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="/stocktradingsystem-3/Public/css/dashboard.css">
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

  <script type="text/javascript" src="/stocktradingsystem-3/Public/js/sidenav.js"></script>
  <script>$('[data-sidenav]').sidenav();</script>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">  
     <?php if(($export) > "0"): ?><div class="table-responsive"> 
       <table class=" table table-striped">
       <thead><tr><th style="text-align: center;">证券名称(代码)</th>
           <th style="text-align: center;">买入/卖出</th>
           <th style="text-align: center;">成交价格</th>
           <th style="text-align: center;">成交数量</th>
           <th style="text-align: center;">成交金额</th>
           <th style="text-align: center;">成交时间</th>
        </tr>
       </thead>
       <tbody>
        <?php if(is_array($deal_info)): $i = 0; $__LIST__ = $deal_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$deal_info): $mod = ($i % 2 );++$i;?><tr><td style="text-align: center;vertical-align: middle"><?php echo ($deal_info["stockname"]); ?>(<?php echo ($deal_info["stockid"]); ?>)</td>
              <td style="text-align: center;vertical-align: middle"><?php echo ($deal_info["operation"]); ?></td>
              <td style="text-align: center;vertical-align: middle"><?php echo ($deal_info["deal_price"]); ?></td>
              <td style="text-align: center;vertical-align: middle"><?php echo ($deal_info["dealed_amount"]); ?></td>
              <td style="text-align: center;vertical-align: middle"><?php echo ($deal_info["dealed_value"]); ?></td>
              <td style="text-align: center;vertical-align: middle"><?php echo ($deal_info["time_disp"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>    
       </tbody></table>
      <?php else: ?>暂时没有数据<?php endif; ?>
   </div>
 </div>
   <script type="text/javascript">
    window.onload=function(){
      var item=document.getElementById("menu");
      var itemss=item.getElementsByTagName("li");
      itemss[3].className+="active";
    }
 </script>
 </body>
 </html>