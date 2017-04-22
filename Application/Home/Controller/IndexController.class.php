<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	function _initialize(){
		header("Content-type:text/html;charset=utf-8");
		if(!isset($_SESSION['username']) || $_SESSION['username']==''){
				$this->redirect('Login/login');
			}
	}
	function index(){
		$this->redirect('buyStock');
	}

	function buyStock(){
		$personalAccount = M('personal_stock_account');
		$condition['userid'] = $_SESSION['userid'];
		$personalAccount_info  = $personalAccount->where($condition)->find();

		$this->assign('bankroll_usable', $personalAccount_info['bankroll_usable']);
		$this->display();
	}

	function sellStock(){
		$personalAccount = M('personal_stock_account');
		$condition['userid'] = $_SESSION['userid'];
		$personalAccount_info  = $personalAccount->where($condition)->find();

		$this->assign('bankroll_usable', $personalAccount_info['bankroll_usable']);

		
		$this->display();
	}	

	function addBuy(){
		$stock = M('stock');
		$condition['stockid'] = $_POST['stockid'];
		if (!$stock->where($condition)->find()){
			$this->error("请输入正确的股票代码");
		}

		$stockholder = M('stockholder');
		$condition['userid'] =  $_SESSION['userid'];
		$sh = $stockholder->where($condition)->find();

		$data['stockid'] = $_POST['stockid'];
		$data['commission_price'] = $_POST['commission_price'];
		$data['direction'] = '0';
		$data['time'] = time();
		$data['commission_account'] =  $_POST['commission_account'];
		$data['stockholderid'] = $sh['stockholderid'];
		$data['state'] = '2';

		$commission = M('commission');
		if (!$commission->add($data))
			$this->error("下单失败");

		$this->success("下单成功", "Index/buyStock");
	}

	function addSell(){
		$stockholder = M('stockholder');
		$condition['userid'] =  $_SESSION['userid'];
		$sh = $stockholder->where($condition)->find();

		$data['stockid'] = $_POST['stockid'];
		$data['commission_price'] = $_POST['commission_price'];
		$data['direction'] = '1';
		$data['time'] = time();
		$data['commission_account'] =  $_POST['commission_account'];
		$data['stockholderid'] = $sh['stockholderid'];
		$data['state'] = '2';

		$commission = M('commission');
		if (!$commission->add($data))
			$this->error("下单失败");

		$this->success("下单成功", "Index/sellStock");
	}

	function revoke(){
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
	
	function doRevoke(){
		$stockid = $_GET['stockid'];
		
		$commission = M('commission');
		$condition['stockid'] = $stockid;
		if (!$commission->where($condition)->delete()){
			$this->error('撤单失败');
		}
		$this->success('撤单成功');
	}

	function showHoldInfo(){
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

	function showTodayCommission(){
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

	function showTodayDeal(){
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

	function showDeal(){
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

	function showPersonalAccount(){
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