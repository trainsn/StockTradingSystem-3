<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	function _initialize(){
		header("Content-type:text/html;charset=utf-8");
		if(!isset($_SESSION['username']) || $_SESSION['username']==''){
				$this->redirect('Login/login');
				//$this->error('您还没有登录', U('Login/login'));
		}else {		//判断当前登录用户是否有资金账户存在，不然不允许其进入系统
			$personalAccount = M('personal_stock_account');
			$condition['userid'] = $_SESSION['userid'];
			//var_dump($condition);
			$personalAccount_info  = $personalAccount->where($condition)->find();
			//var_dump($personalAccount_info);
			if (!$personalAccount_info){
				session_destroy();
				$this->error('您还没有资金账户', U('Login/login'));
			}
		}
	}

	function index(){	
		$this->redirect('showPersonalAccount');

	}

	function check_stockholder(){
		$stockholder = M('stockholder');
		$condition['userid'] =  $_SESSION['userid'];
		if (!$stockholder->where($condition)->find()){
			$this->error('您还没有证券账户');
		}
	}

	function buyStock(){		//买入股票界面
		$this->check_stockholder();

		//从资金账户中查询出当前用户的可用资金，显示在前端当中
		$personalAccount = M('personal_stock_account');
		$condition['userid'] = $_SESSION['userid'];
		$personalAccount_info  = $personalAccount->where($condition)->find();

		//var_dump($personalAccount_info['bankroll_usable']);
		$this->assign('bankroll_usable', $personalAccount_info['bankroll_usable']);
		$this->display();
	}

	function sellStock(){		//卖出股票界面
		$this->check_stockholder();

		$personalAccount = M('personal_stock_account');
		$condition['userid'] = $_SESSION['userid'];
		$personalAccount_info  = $personalAccount->where($condition)->find();

		$this->assign('bankroll_usable', $personalAccount_info['bankroll_usable']);		
		$this->display();
	}	

	function addBuy(){	//买入股票逻辑代码，实际修改数据库
		//首先进行一系列验证
		$this->check_stockholder();

		$stock = M('stock');
		$condition['stockid'] = $_POST['stockid'];
		if (!$stock->where($condition)->find()){
			$this->error("委托失败，不存在该股票代码");
		}

		if (empty($_POST['commission_price']))
			$this->error('委托金额不能为空');
		if (empty($_POST['commission_account']))
			$this->error('委托数量不能为空');

		$stockholder = M('stockholder');
		$condition['userid'] =  $_SESSION['userid'];
		$sh = $stockholder->where($condition)->find();

		$personalAccount = M('personal_stock_account');
		$condition_personal['userid'] = $_SESSION['userid'];
		$personalAccount_info  = $personalAccount->where($condition_personal)->find();

		if ( $_POST['commission_account'] % 100 != 0){
			$this->error('买进时不能以碎股进行委托，最小单位是1手(100股)');
		}else if ($_POST['commission_account'] * $_POST['commission_price'] > $personalAccount_info['bankroll_usable']){
			$this->error('总价超过可用资金');
		}

		//资金账户做相应的修改
		$personalAccount->where($condition_personal)->setDec('bankroll_usable',$_POST['commission_account'] * $_POST['commission_price']); // 可用资金-
		$personalAccount->where($condition_personal)->setInc('bankroll_freezed',$_POST['commission_account'] * $_POST['commission_price']); // 冻结资金+

		//添加委托记录
		$data['stockid'] = $_POST['stockid'];
		$data['commission_price'] = $_POST['commission_price'];
		$data['direction'] = '0';
		$data['commission_time'] = time();
		$data['commission_account'] =  $_POST['commission_account'];
		$data['stockholderid'] = $sh['stockholderid'];
		$data['state'] = '2';

		$commission = M('commission');
		if (!$commission->add($data))
			$this->error("下单失败");

		$this->success("下单成功", U("Index/buyStock"));
	}

	function addSell(){	//卖出股票逻辑代码，实际修改数据库
		//和买入一样，首先进行一系列验证
		$this->check_stockholder();

		$stock = M('stock');
		$condition_stock['stockid'] = $_POST['stockid'];
		if (!$stock->where($condition_stock)->find()){
			$this->error("委托失败，不存在该股票代码");
		}

		if (empty($_POST['commission_price']))
			$this->error('委托金额不能为空');
		if (empty($_POST['commission_account']))
			$this->error('委托数量不能为空');

		$stockholder = M('stockholder');
		$condition['userid'] =  $_SESSION['userid'];
		$sh = $stockholder->where($condition)->find();

		$hold = M('hold_stock_info');
		$condition_hold['stockholderid'] = $sh['stockholderid'];
		$hold_info = $hold->join('stock_stock')->where($condition_hold)->find();

		//var_dump($hold_info);
		if ($hold_info['amount_usable'] <  $_POST['commission_account']){
			$this->error('卖出数量超出最大可卖数');
		}
		//在持仓信息中，更新可卖数量
		$hold->where($condition_hold)->setDec('amount_usable', $_POST['commission_account']);

		//插入委托记录
		$data['stockid'] = $_POST['stockid'];
		$data['commission_price'] = $_POST['commission_price'];
		$data['direction'] = '1';
		$data['commission_time'] = time();
		$data['commission_account'] =  $_POST['commission_account'];
		$data['stockholderid'] = $sh['stockholderid'];
		$data['state'] = '2';

		$commission = M('commission');
		if (!$commission->add($data))
			$this->error("下单失败");

		$this->success("下单成功", U("Index/sellStock"));
	}

	function revoke(){	//撤单界面，查询所有state=2的委托记录，即已提交记录
		$this->check_stockholder();

		$stockholder = M('stockholder');
		$condition['userid'] =  $_SESSION['userid'];
		$sh = $stockholder->where($condition)->find();

		$commission = M('commission');
		$condition_com['stockholderid'] = $sh['stockholderid'];
		$condition_com['state'] = '2';
		$commission_info = $commission->join('stock_stock on stock_stock.stockid = stock_commission.stockid')->where($condition_com)->select();

		for ($i=0;$i<count($commission_info);$i++){
			switch($commission_info[$i]['direction']){
				case '0':
					$commission_info[$i]['direction_disp'] = '买入';
					break;
				case '1':
					$commission_info[$i]['direction_disp'] = '卖出';
					break;
			}

			switch($commission_info[$i]['state']){
				case '0':
					$commission_info[$i]['state_disp'] = '已撤销';
					break;
				case '1':
					$commission_info[$i]['state_disp'] = '已成交';
					break;
				case '2':
					$commission_info[$i]['state_disp'] = '已提交';
					break;
			}

			$commission_info[$i]['time_disp'] = date("Y-m-d H:i:s",$commission_info[$i]['commission_time']);
		}

		//var_dump($commission_info);
		$this->assign('export',count($commission_info));
		$this->assign('commission_info',$commission_info);
		$this->display();
	}
	
	function doRevoke(){	//实际撤销逻辑代码
		$this->check_stockholder();

		//当用户点击撤销按钮的时候，用GET方法向服务器发送icommissiond信息
		$commissionid = $_GET['commissionid'];
		
		$commission = M('commission');
		$condition['commissionid'] = $commissionid;
		$commission_info = $commission->where($condition)->find();

		if ($commission_info['direction'] == '1'){	//撤销卖出 需要修改持仓信息 添加可处理股票	
			$hold = M('hold_stock_info');
			$condition_hold['stockholderid'] = $commission_info['stockholderid'];
			$hold->where($condition_hold)->SetInc('amount_usable', $commission_info['commission_account']);
		}else if ($commission_info['direction'] == '0'){	//撤销买入 需要修改资金账户信息
			$personalAccount = M('personal_stock_account');
			$condition_personal['userid'] = $_SESSION['userid'];

			$personalAccount->where($condition_personal)->setInc('bankroll_usable',$commission_info['commission_account'] * $commission_info['commission_price']); // 可用资金+
			$personalAccount->where($condition_personal)->setDec('bankroll_freezed',$commission_info['commission_account'] * $commission_info['commission_price']); // 冻结资金-
		}

		//删除撤单信息
		if (!$commission->where($condition)->delete()){
			$this->error('撤单失败');
		}
		$this->success('撤单成功');
	}

	function showHoldInfo(){	//显示持仓信息
		$this->check_stockholder();

		$stockholder = M('stockholder');
		$condition['userid'] =  $_SESSION['userid'];
		$sh = $stockholder->where($condition)->find();

		$hold = M('hold_stock_info');
		$condition_hold['stockholderid'] = $sh['stockholderid'];
		$hold_info = $hold->join('stock_stock')->where($condition_hold)->select();

		$this->assign('export',count($hold_info));
		$this->assign('hold_info',$hold_info);
		$this->display();
	}

	function showTodayCommission(){		//显示当日委托信息
		$this->check_stockholder();

		$stockholder = M('stockholder');
		$condition['userid'] =  $_SESSION['userid'];
		$sh = $stockholder->where($condition)->find();

		$current_day = time() - time()%86400;

		$commission = M('commission');
		$condition_com['stockholderid'] = $sh['stockholderid'];
		$condition_com['commission_time'] = array('egt', $current_day);
		$commission_info = $commission->join('stock_stock on stock_stock.stockid = stock_commission.stockid')->where($condition_com)->select();

		for ($i=0;$i<count($commission_info);$i++){
			switch($commission_info[$i]['direction']){
				case '0':
					$commission_info[$i]['direction_disp'] = '买入';
					break;
				case '1':
					$commission_info[$i]['direction_disp'] = '卖出';
					break;
			}

			switch($commission_info[$i]['state']){
				case '0':
					$commission_info[$i]['state_disp'] = '已撤销';
					break;
				case '1':
					$commission_info[$i]['state_disp'] = '已成交';
					break;
				case '2':
					$commission_info[$i]['state_disp'] = '已提交';
					break;
			}
			$commission_info[$i]['time_disp'] = date("Y-m-d H:i:s",$commission_info[$i]['commission_time']);
		}

		//var_dump($commission_info);
		$this->assign('export',count($commission_info));
		$this->assign('commission_info',$commission_info);
		$this->display();
	}

	function showTodayDeal(){	//显示当日成交信息
		$this->check_stockholder();

		$stockholder = M('stockholder');
		$condition['userid'] =  $_SESSION['userid'];
		$sh = $stockholder->where($condition)->find();

		$current_day = time() - time()%86400;
		$deal = M('deal');
		$condition_deal['stockholderid'] = $sh['stockholderid'];
		$condition_deal['deal_time'] = array('egt', $current_day);
		//var_dump($condition_deal);

		$deal_info = $deal->join('stock_commission on (stock_commission.commissionid = stock_deal.in_commission) or (stock_commission.commissionid = stock_deal.out_commission)')->join('stock_stock')->where($condition_deal)->select();
		//var_dump($deal_info);

		for ($i=0;$i<count($deal_info);$i++){
			if ($deal_info[$i]['commissionid'] == $deal_info[$i]['in_commission'])
				$deal_info[$i]['operation'] = '买入';
			if ($deal_info[$i]['commissionid'] == $deal_info[$i]['out_commission'])
				$deal_info[$i]['operation'] = '卖出';

			$deal_info[$i]['time_disp'] = date("Y-m-d H:i:s",$deal_info[$i]['deal_time']);
		}

		$this->assign('export',count($deal_info));
		$this->assign('deal_info',$deal_info);
		$this->display();
	}

	function showDeal(){	//显示历史成交信息
		$this->check_stockholder();
		
		$stockholder = M('stockholder');
		$condition['userid'] =  $_SESSION['userid'];
		$sh = $stockholder->where($condition)->find();

		$deal = M('deal');
		$condition_deal['stockholderid'] = $sh['stockholderid'];
		//var_dump($condition_deal);

		$deal_info = $deal->join('stock_commission on (stock_commission.commissionid = stock_deal.in_commission) or (stock_commission.commissionid = stock_deal.out_commission)')->join('stock_stock')->where($condition_deal)->select();
		//var_dump($deal_info);

		for ($i=0;$i<count($deal_info);$i++){
			if ($deal_info[$i]['commissionid'] == $deal_info[$i]['in_commission'])
				$deal_info[$i]['operation'] = '买入';
			if ($deal_info[$i]['commissionid'] == $deal_info[$i]['out_commission'])
				$deal_info[$i]['operation'] = '卖出';

			$deal_info[$i]['time_disp'] = date("Y-m-d H:i:s",$deal_info[$i]['deal_time']);
		}
		
		$this->assign('export',count($deal_info));
		$this->assign('deal_info',$deal_info);
		$this->display();
	}

	function showPersonalAccount(){		//显示资金账户信息
		$personalAccount = M('personal_stock_account');
		$condition['userid'] = $_SESSION['userid']; 
		$personalAccount_info = $personalAccount->where($condition)->find();

		//var_dump($pa);
		if (empty($personalAccount))
			$export = 0;
		else 
			$export = 1;
		$this->assign('export', $export);
		$this->assign('personalAccount_info', $personalAccount_info);
		$this->display();
	}
}