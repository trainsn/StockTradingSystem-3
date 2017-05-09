<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>股票交易系统——个人中心</title>
        <link rel="stylesheet" href="/stocktradingsystem-3/Public/css/bootstrap.min.css">  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="/stocktradingsystem-3/Public/css/sidebar-menu.css">
    </head>

  <body id="index">
        <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" href="#" style="
    width: 430px;
">
        <img alt="Brand" class="col-sm-2 col-xs-3" src="/stocktradingsystem-3/Public/logo2.png" style="
    width: 55px;
">  
    股票交易个人中心
    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
    </a>
    </div>
    <ul class="nav navbar-nav navbar-right">
    <li><a><?php echo $_SESSION['username']?>，今天是<?php echo date('Y-m-d', time())?></a></li>
    <li><a href="javascript:ms=confirm('确定退出');ms?location.href='/stocktradingsystem-3/index.php/Home/Login/logout':history.go(0)" >退出登录</a></li>
    </ul>
   </div>
   </nav>
    <section class="col-sm-3 col-xs-5">
    <ul class="sidebar-menu">
      <li class="sidebar-header">菜单</li>
      <li>
        <a href="/stocktradingsystem-3/index.php/Home/Index/buyStock">
          <i class="fa fa-th"></i> <span>买入</span>
        </a>
      </li>
      <li>
        <a href="/stocktradingsystem-3/index.php/Home/Index/sellStock">
          <i class="fa fa-share"></i> <span>卖出</span>
        </a>
      </li>
      <li>
        <a href="/stocktradingsystem-3/index.php/Home/Index/revoke">
          <i class="fa fa-dashboard"></i> <span>撤单</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-files-o"></i> <span>查询</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="/stocktradingsystem-3/index.php/Home/Index/showPersonalAccount"><i class="fa fa-circle-o"></i> 资金账户信息</a></li>
          <li><a href="/stocktradingsystem-3/index.php/Home/Index/showHoldInfo"><i class="fa fa-circle-o"></i> 持仓信息</a></li>
          <li><a href="/stocktradingsystem-3/index.php/Home/Index/showTodayDeal"><i class="fa fa-circle-o"></i> 当日成交</a></li>
          <li><a href="/stocktradingsystem-3/index.php/Home/Index/showTodayCommission"><i class="fa fa-circle-o"></i> 当日委托</a></li>
          <li><a href="/stocktradingsystem-3/index.php/Home/Index/showDeal"><i class="fa fa-circle-o"></i> 历史成交</a></li>
        </ul>
      </li>
    </ul>
  </section>

  <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
  <script src="/stocktradingsystem-3/Public/js/sidebar-menu.js"></script>
  <script>
    $.sidebarMenu($('.sidebar-menu'))
  </script>
  
    <div class="col-sm-8 col-xs-7">    
     <?php if(($export) > "0"): ?><table class="table" style="margin:0;">
      <tr>
      <!--<td style="text-align: center;vertical-align: middle">
        <div style="height:34px; padding:9px;">
        <p id="accountInfo" style="font-size:16px; font-family:'微软雅黑'">按时间查询</p>
        </div>
      </td>-->
      <td style="text-align: center;vertical-align: middle">
        <div style="height:34px; padding:9px;">
        <p id="accountInfo" style="font-size:16px; font-family:'微软雅黑'">自</p>
        </div>
      </td>
      <td style="text-align: center;vertical-align: middle">
        <div>
        <input type="date" style="font-size:16px; font-family:'微软雅黑'" class="form-control" id="start_date"/>
        </div>
      </td>
      <td style="text-align: center;vertical-align: middle">
        <div>
        <input type="time" style="font-size:16px; font-family:'微软雅黑'" class="form-control" id="start_time" value="00:00:01" />
        </div>
      </td>
      <td style="text-align: center;vertical-align: middle">
        <div style="height:34px; padding:9px;">
        <p id="accountInfo" style="font-size:16px; font-family:'微软雅黑'">至</p>
        </div>
      </td>
      <td style="text-align: center;vertical-align: middle">
        <div>
        <input type="date" style="font-size:16px; font-family:'微软雅黑'" class="form-control" id="end_date"/>
        </div>
      </td>
      <td style="text-align: center;vertical-align: middle">
        <div>
        <input type="time" style="font-size:16px; font-family:'微软雅黑'" class="form-control" id="end_time" value="23:59:59"/>
        </div>
      </td>
      <td style="text-align: center;vertical-align: middle">
      <div>
          <input type="button" class="btn btn-primary" name="search" value="查询" onclick="Search();">
        </div>
      </td>
      </tr>
       <tr>
      <td colspan="8" style="height:20px; padding-top:1px;padding-bottom:0;">
      <div>
        <p id="searchInfo" style="font-size:16px; font-family:'微软雅黑';color:red">&nbsp;</p>
        </div>
      </td>
      </tr>
    </table>

    <table class=" table table-striped table-bordered">
       <thead><tr><th style="text-align: center;">证券名称(代码)</th>
           <th style="text-align: center;">买入/卖出</th>
           <th style="text-align: center;">成交价格</th>
           <th style="text-align: center;">成交数量</th>
           <th style="text-align: center;">成交金额</th>
           <th style="text-align: center;">成交时间</th>
        </tr>
       </thead>
       <tbody id="myTableBody">
       </tbody>
    </table>
    <?php else: ?>暂时没有数据<?php endif; ?>

   </div>
  </div>

  <script type="text/javascript">
  function GetCurrentDate()
  {
    var currentDate = new Date();
    var outStr = "";
    var month,date;

    outStr = outStr+currentDate.getFullYear();//获取完整的年份(4位,1970-)

    month = 1+currentDate.getMonth();//获取当前月份(gatMonth得到的是0-11,0代表1月)
    if(month<10)
      outStr = outStr+"-"+"0"+month;
    else
      outStr = outStr+"-"+month; 

    date = currentDate.getDate(); //获取当前日(1-31)
    if(date<10)
      outStr = outStr+"-"+"0"+date;
    else
      outStr = outStr+"-"+date; 

    document.getElementById("start_date").value = outStr;
    document.getElementById("end_date").value = outStr;
  }

    var arr = new Array();
    var arrLen = 0;
    arr["stock"] = new Array();
    arr["operation"] = new Array();
    arr["price"] = new Array();
    arr["amount"] = new Array();
    arr["value"] = new Array();
    arr["time"] = new Array();

    <?php if(is_array($deal_info)): $i = 0; $__LIST__ = $deal_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$deal_info): $mod = ($i % 2 );++$i;?>arr["stock"].push("<?php echo ($deal_info["stockname"]); ?>(<?php echo ($deal_info["stockid"]); ?>)");
      arr["operation"].push("<?php echo ($deal_info["operation"]); ?>");
      arr["price"].push("<?php echo ($deal_info["deal_price"]); ?>");
      arr["amount"].push("<?php echo ($deal_info["dealed_amount"]); ?>");
      arr["value"].push("<?php echo ($deal_info["dealed_value"]); ?>");
      arr["time"].push("<?php echo ($deal_info["time_disp"]); ?>");
      arrLen = arrLen+1;<?php endforeach; endif; else: echo "" ;endif; ?>

  function Search()
  {
    var strStart = document.getElementById("start_date").value+" "+document.getElementById("start_time").value;
    var timestampStart = Date.parse(new Date(strStart))/1000;//获取时间戳(以s为单位)
    var strEnd = document.getElementById("end_date").value+" "+document.getElementById("end_time").value;
    var timestampEnd = Date.parse(new Date(strEnd))/1000;//获取时间戳(以s为单位)

    if(timestampStart > timestampEnd)
    {
      document.getElementById("searchInfo").innerHTML = "查询起始时间需早于截止时间";
      return false;
    }

    var outHTML = "";
    var time;

    for (var i = 0; i < arrLen; i++) 
    {
      time = Date.parse(new Date(arr["time"][i]))/1000;
      if(time >= timestampStart && time <= timestampEnd)
      {
        outHTML = outHTML + "<tr>";
        outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["stock"][i]+"</td>";
        outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["operation"][i]+"</td>";
        outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["price"][i]+"</td>";
        outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["amount"][i]+"</td>";
        outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["value"][i]+"</td>";
        outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["time"][i]+"</td>";
        outHTML = outHTML + "</tr>";
      }
    }
    document.getElementById("myTableBody").innerHTML = outHTML;
    document.getElementById("searchInfo").innerHTML = "&nbsp;";
    return true;
  }


  window.onload=function(){
    GetCurrentDate();

    var outHTML = "";
    for (var i = 0; i < arrLen; i++) 
    {
      outHTML = outHTML + "<tr>";
      outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["stock"][i]+"</td>";
      outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["operation"][i]+"</td>";
      outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["price"][i]+"</td>";
      outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["amount"][i]+"</td>";
      outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["value"][i]+"</td>";
      outHTML = outHTML + "<td style=\"text-align: center;vertical-align: middle\">"+arr["time"][i]+"</td>";
      outHTML = outHTML + "</tr>";
    }
    document.getElementById("myTableBody").innerHTML = outHTML;
  } 

  </script>
 </body>
 </html>