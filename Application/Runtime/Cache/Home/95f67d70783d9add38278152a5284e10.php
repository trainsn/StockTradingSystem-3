<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>查询界面</title>
    <link rel="stylesheet" href="/stocktradingsystem-3/Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="/stocktradingsystem-3/Public/css/sidebar-menu.css">
    <style type="text/css">
        .warning{
            padding: 5px;
            color: #A0A0A0;
        }
        #head{
            height: 90px;
            width: 774px;
            background-color: #f5f5f5;
            margin-left:270px;
        }
        #checklogin{
            float:right;
            text-align: center;
            line-height: 30px;
            height: 29px;
            position: absolute;
            left:690px;
        }
        #checklogin2{
            float:right;
            text-align: center;
            line-height: 30px;
            position: absolute;
            left:870px;
        }
        .headli{
            float: left;
            list-style: none;
            margin-left: 20px;
        }
        a.login:link{
            color:#000000;
        }
        a.login:hover{
            color:#FF0000;
            text-decoration: none;
        }
        #last{
            height: 120px;
            background-color: rgba(22, 43, 62, 0.19);
            width: 774px;
            margin-left:270px;
            padding-top: 20px;
            text-align: center;
        }
        span{
            margin-bottom: 10px;
        }
        #pi{
            height: 30px;
            width: auto;
            text-align: center;
            position: relative;
            margin-left: 120px;
            float:left;
            margin-top: 30px;
            font-family: "微软雅黑";
        }
    </style>
</head>
<body id="index" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="head">
    <img src="/stocktradingsystem-3/Public/head.jpg" height="80px" width="80px" style="float:left;">
    <div id="pi">
        <h2><strong>让我们成为你的最佳投资助手</strong></h2>
    </div>
       <?php if($_SESSION['username']): ?><div id="checklogin">
           <ul>
               <li class="headli"><a href="/stocktradingsystem-3/index.php/Home/Index/showPersonalAccount"><?php echo $_SESSION['username']?></a>，今天是<?php echo date('Y-m-d', time())?></li>
               <li class="headli"><a href="javascript:ms=confirm('确定退出');ms?location.href='/stocktradingsystem-3/index.php/Home/Login/logout':history.go(0)" >退出登录</a></li>
           </ul>
           </div>
           <?php else: ?>
           <div id="checklogin2">
        <ul>
            <li class="headli"><a href="/stocktradingsystem-3/index.php/Home/Login/login" class="login">请登录</a></li>
            <li class="headli"><a href="/stocktradingsystem-3/index.php/Home/Register/reg" class="login">注册</a></li>
        </ul>
           </div><?php endif; ?>
    </div>
<hr style="height:1px;border:none;border-top:1px solid #555555;width: 60%" align="center"; />
<div>
<table width="774" border="0" align="center" cellpadding="0" cellspacing="0">
                    <form class="form-horizontal" action="/stocktradingsystem-3/index.php/Home/Stock/searchstock" method="post" name="myform" id="myform" onsubmit="return checkbox();">
                        <tr>
                            <td height="30" bgcolor="#f5f5f5">
                                <div align="center"><font color="#990000">请输入要查询的股票代码或者名称</font>
                                    <input type="text"  id="stock" name="stock" value="<?php echo ($stock); ?>" >
                                    <input type="submit" class="btn btn-primary" name="submit" value="查询" class="publish">
                                </div>
                            </td>
                        </tr>
                    </form>
    </table>
</div>
<div>
    <?php if($result != null): ?><table width="774" border="0" align="center" >
            <tr>
                <th width="14%" valign="top" bgcolor="#bdc8d0" height="10px">
                <div align="center"><strong><font color="#003366">股票代码</font></strong></div>
                </th>
                <th width="16%" valign="top" bgcolor="#bdc8d0" height="10px">
                    <div align="center"><strong><font color="#003366">股票名字</font></strong></div>
                </th>
                <th width="14%" valign="top" bgcolor="#bdc8d0" height="10px">
                    <div align="center"><strong><font color="#003366">开盘价格</font></strong></div>
                </th>
                <th width="14%" valign="top" bgcolor="#bdc8d0" height="10px">
                    <div align="center"><strong><font color="#003366">今日最高</font></strong></div>
                </th>
                <th width="14%" valign="top" bgcolor="#bdc8d0" height="10px">
                    <div align="center"><strong><font color="#003366">今日最低</font></strong></div>
                </th>
                <th width="14%" valign="top" bgcolor="#bdc8d0" height="10px">
                    <div align="center"><strong><font color="#003366">当前价格</font></strong></div>
                </th>
            </tr>
            <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td style="text-align: center;vertical-align: middle"><a href="detailstock/code/<?php echo ($vo["code"]); ?>" target="_blank"><?php echo ($vo["code"]); ?></a></td>
                    <td style="text-align: center;vertical-align: middle"><?php echo ($vo["name"]); ?></td>
                    <td style="text-align: center;vertical-align: middle"><?php echo ($vo["open"]); ?></td>
                    <td style="text-align: center;vertical-align: middle"><?php echo ($vo["high"]); ?></td>
                    <td style="text-align: center;vertical-align: middle"><?php echo ($vo["low"]); ?></td>
                    <td style="text-align: center;vertical-align: middle"><?php echo ($vo["trade"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table><?php endif; ?>
</div>
<table width="774" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#d5d5d5">
    <tr>
        <td>
        <div  style="background-color: rgba(120,120,120,0.44)"><strong><font color="#ffffff">沪市指数行情</font></strong></div>
        </td>
    </tr>
    <tr bgcolor="#f4f5f5">
        <td width="14%">&nbsp;</td>
        <td width="12%">
            <div align="center"><strong>当前点数</strong></div>
        </td>
        <td width="12%">
            <div align="center"><strong>当前价格</strong></div>
        </td>
        <td width="12%">
            <div align="center"><strong>涨跌率/%</strong></div>
        </td>
        <td width="12%">
            <div align="center"><strong>成交手/万手</strong></div>
        </td>
        <td width="12%">
            <div align="center"><strong>成交额/万元</strong></div>
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td>
        <div align="center">
            <strong><font color="333333">    上证指数</font></strong>
        </div>
        </td>
        <td>
            <div align="center" id="上证指数1"></div>
        </td>
        <td>
            <div align="center" id="上证指数2">3098.91</div>
        </td>
        <td>
            <div align="center" id="上证指数3">3085.93</div>
        </td>
        <td>
            <div align="center" id="上证指数4">3090.23</div>
        </td>
        <td>
            <div align="center" id="上证指数5">0.22%
        </div>
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td>
            <div align="center">
                <strong><font color="333333">    Ａ股指数</font></strong>
            </div>
        </td>
        <td>
            <div align="center" id="A股指数1">3231.68</div>
        </td>
        <td>
            <div align="center" id="A股指数2">3245.27</div>
        </td>
        <td>
            <div align="center" id="A股指数3">3231.68</div>
        </td>
        <td>
            <div align="center" id="A股指数4">3236.20</div>
        </td>
        <td>
            <div align="center" id="A股指数5">0.22%</div>
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td>
            <div align="center">
                <strong><font color="333333">    Ｂ股指数</font></strong>
            </div>
        </td>
        <td>
            <div align="center" id="B股指数1">321.83</div>
        </td>
        <td>
            <div align="center" id="B股指数2">323.20</div>
        </td>
        <td>
            <div align="center" id="B股指数3">321.61</div>
        </td>
        <td>
            <div align="center" id="B股指数4">321.70</div>
        </td>
        <td>
            <div align="center" id="B股指数5">-0.07%</div>
        </td>
    </tr>
</table>
<table width="774" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#d5d5d5">
        <tr>
            <td>
                <div style="background-color: rgba(120,120,120,0.44)"><strong><font color="#ffffff">深市指数行情</font></strong></div>
            </td>
        </tr>
    <tr bgcolor="#f4f5f5">
        <td width="14%">&nbsp;</td>
        <td width="12%">
            <div align="center"><strong>当前点数</strong></div>
        </td>
        <td width="12%">
            <div align="center"><strong>当前价格</strong></div>
        </td>
        <td width="12%">
            <div align="center"><strong>涨跌率/%</strong></div>
        </td>
        <td width="12%">
            <div align="center"><strong>成交手/万手</strong></div>
        </td>
        <td width="12%">
            <div align="center"><strong>成交额/万元</strong></div>
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td>
            <div align="center">
                    <strong><font color="333333">    深证成指</font></strong>
            </div>
        </td>
        <td>
            <div align="center" id="深证成指1"></div>
        </td>
        <td>
            <div align="center" id="深证成指2">3098.91</div>
        </td>
        <td>
            <div align="center" id="深证成指3">3085.93</div>
        </td>
        <td>
            <div align="center" id="深证成指4">3090.23</div>
        </td>
        <td>
            <div align="center" id="深证成指5">0.22%
            </div>
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td>
            <div align="center">
                <strong><font color="333333">   深证A指</font></strong>
            </div>
        </td>
        <td>
            <div align="center" id="深证A指1">3231.68</div>
        </td>
        <td>
            <div align="center" id="深证A指2">3245.27</div>
        </td>
        <td>
            <div align="center" id="深证A指3">3231.68</div>
        </td>
        <td>
            <div align="center" id="深证A指4">3236.20</div>
        </td>
        <td>
            <div align="center" id="深证A指5">0.22%</div>
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td>
            <div align="center">
                <strong><font color="333333">    深证B指</font></strong>
            </div>
        </td>
        <td>
            <div align="center" id="深证B指1">321.83</div>
        </td>
        <td>
            <div align="center" id="深证B指2">323.20</div>
        </td>
        <td>
            <div align="center" id="深证B指3">321.61</div>
        </td>
        <td>
            <div align="center" id="深证B指4">321.70</div>
        </td>
        <td>
            <div align="center" id="深证B指5">-0.07%</div>
        </td>
    </tr>
</table>
<table width="774" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="50%" valign="top"><table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#666666">
            <tr bgcolor="#f4e4bd">
                <td height="20" colspan="4"><strong><font color="#be5711">沪市最新涨幅排名</font></strong></td>
            </tr>
            <tr bgcolor="#fcf3e4">
                <td bgcolor="#fcf3e4">
                    <div align="center"><font color="#b58f46">股票名称</font></div>
                </td>
                <td width="23%">
                    <div align="center"><font color="#b58f46">昨收</font></div>
                </td>
                <td width="23%">
                    <div align="center"><font color="#b58f46">今收</font></div>
                </td>
                <td width="23%">
                    <div align="center"><font color="#b58f46">涨幅</font></div>
                </td>
            </tr>
            <?php if(is_array($result2)): $i = 0; $__LIST__ = $result2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><a href="detailstock/code/<?php echo ($vo["code"]); ?>" target="_blank"><?php echo ($vo["name"]); ?></a></td>
                    <td><?php echo ($vo["high"]); ?></td>
                    <td><?php echo ($vo["low"]); ?></td>
                    <td><?php echo ($vo["changepercent"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
        </td>
        <td valign="top"><div align="right">
            <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#666666">
                <tr bgcolor="#f4e4bd">
                    <td height="20" colspan="4"><strong><font color="#be5711">深市最新涨幅排名</font></strong></td>
                </tr>
                <tr bgcolor="#fcf3e4">
                    <td bgcolor="#fcf3e4">
                        <div align="center"><font color="#b58f46">股票名称</font></div>
                    </td>
                    <td width="23%">
                        <div align="center"><font color="#b58f46">昨收</font></div>
                    </td>
                    <td width="23%">
                        <div align="center"><font color="#b58f46">今收</font></div>
                    </td>
                    <td width="23%">
                        <div align="center"><font color="#b58f46">涨幅</font></div>
                    </td>
                </tr>
                <?php if(is_array($result4)): $i = 0; $__LIST__ = $result4;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td><a href="detailstock/code/<?php echo ($vo["code"]); ?>" target="_blank"><?php echo ($vo["name"]); ?></td>
                        <td><?php echo ($vo["high"]); ?></td>
                        <td><?php echo ($vo["low"]); ?></td>
                        <td><?php echo ($vo["changepercent"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
        </div>
        </td>
    </tr>
</table>
<table width="774" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td width="50%" valign="top">
            <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#666666">
                <tr>
                    <td height="20" colspan="4" bgcolor="#f4e4bd"><strong><font color="#be5711">沪市最新跌幅排名</font></strong></td>
                </tr>
                <tr>
                    <td bgcolor="#fcf3e4">
                        <div align="center"><font color="#b58f46">股票名称</font></div>
                    </td>
                    <td width="23%" bgcolor="#fcf3e4">
                        <div align="center"><font color="#b58f46">昨收</font></div>
                    </td>
                    <td width="23%" bgcolor="#fcf3e4">
                        <div align="center"><font color="#b58f46">今收</font></div>
                    </td>
                    <td width="23%" bgcolor="#fcf3e4">
                        <div align="center"><font color="#b58f46">涨幅</font></div>
                    </td>
                </tr>
                <?php if(is_array($result1)): $i = 0; $__LIST__ = $result1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><a href="detailstock/code/<?php echo ($vo["code"]); ?>" target="_blank"><?php echo ($vo["name"]); ?></td>
                    <td><?php echo ($vo["high"]); ?></td>
                    <td><?php echo ($vo["low"]); ?></td>
                    <td><?php echo ($vo["changepercent"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
        </td>
        <td valign="top"><div align="right">
            <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#666666">
                <tr bgcolor="#f4e4bd">
                    <td height="20" colspan="4"><strong><font color="#be5711">深市最新跌幅排名</font></strong></td>
                </tr>
                <tr bgcolor="#fcf3e4">
                    <td bgcolor="#fcf3e4">
                        <div align="center"><font color="#b58f46">股票名称</font></div>
                    </td>
                    <td width="23%">
                        <div align="center"><font color="#b58f46">昨收</font></div>
                    </td>
                    <td width="23%">
                        <div align="center"><font color="#b58f46">今收</font></div>
                    </td>
                    <td width="23%">
                        <div align="center"><font color="#b58f46">涨幅</font></div>
                    </td>
                </tr>
                <?php if(is_array($result3)): $i = 0; $__LIST__ = $result3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td><a href="detailstock/code/<?php echo ($vo["code"]); ?>" target="_blank"><?php echo ($vo["name"]); ?></td>
                        <td><?php echo ($vo["high"]); ?></td>
                        <td><?php echo ($vo["low"]); ?></td>
                        <td><?php echo ($vo["changepercent"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
        </div>
        </td>
    </tr>
</table>
<div id="last">
    <hr width="100%" color=#987cb9 SIZE=3>
    <a href="#">关于我们</a> -
    <a href="#">广告合作</a> -
    <a href="#">联系我们</a> -
    <a href="#">免责声明</a> -
    <a href="#">投诉建议</a>
    <p><strong>&copy;CopyRight  浙江大学2014级GIS 版权所有</strong></p>
</div>
        <script type="text/javascript">
            function checkbox(){
                value = document.getElementById('stock').value;
                if(value == ''|| value == null)
                {
                   alert('输入不能为空');
                    return false;
                }
                else{
                    return true;
                }
            }
        </script>
<script type="text/javascript" src="http://hq.sinajs.cn/list=s_sh000001"></script>
<script type="text/javascript" src="http://hq.sinajs.cn/list=s_sh000002"></script>
<script type="text/javascript" src="http://hq.sinajs.cn/list=s_sh000003"></script>
<script type="text/javascript" src="http://hq.sinajs.cn/list=s_sz399001"></script>
<script type="text/javascript" src="http://hq.sinajs.cn/list=s_sz399107"></script>
<script type="text/javascript" src="http://hq.sinajs.cn/list=s_sz399108"></script>
<script type="text/javascript">
            var elements1 =hq_str_s_sh000001.split(",");
    document.getElementById("上证指数1").innerHTML = elements1[1];
    document.getElementById('上证指数2').innerHTML = elements1[2];
    document.getElementById('上证指数3').innerHTML = elements1[3];
    document.getElementById('上证指数4').innerHTML = elements1[4]/10000;
    document.getElementById('上证指数5').innerHTML = elements1[5];
</script>
<script type="text/javascript">
    var elements1 =hq_str_s_sh000002.split(",");
    document.getElementById("A股指数1").innerHTML = elements1[1];
    document.getElementById('A股指数2').innerHTML = elements1[2];
    document.getElementById('A股指数3').innerHTML = elements1[3];
    document.getElementById('A股指数4').innerHTML = elements1[4]/10000;
    document.getElementById('A股指数5').innerHTML = elements1[5];
</script>
<script type="text/javascript">
    var elements1 =hq_str_s_sh000003.split(",");
    document.getElementById("B股指数1").innerHTML = elements1[1];
    document.getElementById('B股指数2').innerHTML = elements1[2];
    document.getElementById('B股指数3').innerHTML = elements1[3];
    document.getElementById('B股指数4').innerHTML = elements1[4]/10000;
    document.getElementById('B股指数5').innerHTML = elements1[5];
</script>
<script type="text/javascript">
    var elements1 =hq_str_s_sz399001.split(",");
    document.getElementById("深证成指1").innerHTML = elements1[1];
    document.getElementById('深证成指2').innerHTML = elements1[2];
    document.getElementById('深证成指3').innerHTML = elements1[3];
    document.getElementById('深证成指4').innerHTML = elements1[4]/10000;
    document.getElementById('深证成指5').innerHTML = elements1[5];
</script>
<script type="text/javascript">
    var elements1 =hq_str_s_sz399107.split(",");
    document.getElementById("深证A指1").innerHTML = elements1[1];
    document.getElementById('深证A指2').innerHTML = elements1[2];
    document.getElementById('深证A指3').innerHTML = elements1[3];
    document.getElementById('深证A指4').innerHTML = elements1[4]/10000;
    document.getElementById('深证A指5').innerHTML = elements1[5];
</script>
<script type="text/javascript">
    var elements1 =hq_str_s_sz399108.split(",");
    document.getElementById("深证B指1").innerHTML = elements1[1];
    document.getElementById('深证B指2').innerHTML = elements1[2];
    document.getElementById('深证B指3').innerHTML = elements1[3];
    document.getElementById('深证B指4').innerHTML = elements1[4]/10000;
    document.getElementById('深证B指5').innerHTML = elements1[5];
</script>
</body>
</html>