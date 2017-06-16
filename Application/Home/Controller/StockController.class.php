<?php
namespace Home\Controller;
use Think\Controller;
class StockController extends Controller {
	function search(){
        $stock = M('stock');
        $condition1['code']=array('like','6%');
        $result1=$stock->where($condition1)->order('changepercent')->limit(5)->select();
        $this->assign('result1',$result1);
        $condition2['code']=array('like','6%');
        $result2=$stock->where($condition2)->order('changepercent desc')->limit(5)->select();
        $this->assign('result2',$result2);
        $condition3['code']=array('like',array('3%','0%'),'OR');
        $result3=$stock->where($condition3)->order('changepercent')->limit(5)->select();
        $this->assign('result3',$result3);
        $condition3['code']=array('like',array('3%','0%'),'OR');
        $result3=$stock->where($condition3)->order('changepercent desc')->limit(5)->select();
        $this->assign('result4',$result3);
        $this->display();
    }
	function searchstock(){
	    $stock  = M('stock');
	    if ($_POST['stock'] != '' || $_POST['stock'] != null) {
	        $condition['code'] = $_POST['stock'];
	        $condition['name'] = array('like', "%" . $_POST['stock'] . "%");
	        $condition['_logic'] = 'OR';
	        $result = $stock->where($condition)->select();
	        if ($result) {
	            $this->assign('result', $result);
	            $condition1['code'] = array('like', '6%');
	            $result1 = $stock->where($condition1)->order('changepercent')->limit(5)->select();
	            $this->assign('result1', $result1);
	            $condition2['code'] = array('like', '6%');
	            $result2 = $stock->where($condition2)->order('changepercent desc')->limit(5)->select();
	            $this->assign('result2', $result2);
	            $condition3['code'] = array('like', array('3%', '0%'), 'OR');
	            $result3 = $stock->where($condition3)->order('changepercent')->limit(5)->select();
	            $this->assign('result3', $result3);
	            $condition3['code'] = array('like', array('3%', '0%'), 'OR');
	            $result3 = $stock->where($condition3)->order('changepercent desc')->limit(5)->select();
	            $this->assign('result4', $result3);
	            $this->display("search");
	        } else {
	//            $condition1['code']=array('like','6%');
	//            $result1=$stock->where($condition1)->order('changepercent')->limit(5)->select();
	//            $this->assign('result1',$result1);
	//            $condition2['code']=array('like','6%');
	//            $result2=$stock->where($condition2)->order('changepercent desc')->limit(5)->select();
	//            $this->assign('result2',$result2);
	//            $condition3['code']=array('like',array('3%','0%'),'OR');
	//            $result3=$stock->where($condition3)->order('changepercent')->limit(5)->select();
	//            $this->assign('result3',$result3);
	//            $condition3['code']=array('like',array('3%','0%'),'OR');
	//            $result3=$stock->where($condition3)->order('changepercent desc')->limit(5)->select();
	//            $this->assign('result4',$result3);
	//            $this->display("search");
	            $this->error("错误的页面");
	        }
	    }
	}

    function detailstock(){
        $this->assign("code",$_GET['code']);
		$stock  = M('stock');
		if ($_GET['code'] != '' || $_GET['code'] != null) {
        $condition['code'] = $_GET['code'];
        $result = $stock->where($condition)->find();
        if ($result) {
            $this->assign('result', $result);
            $this->display("detailstock");
        } else {
            $this->error("错误的页面");
        }
		}
		else {
            $this->error("不知道你怎么进来的");
        }       
    } 

    function detailstockIndex($code){
        $this->assign("code",$code);
		$stock  = M('stock');
		if ($code != '' || $code != null) {
        $condition['code'] = $code;
        $result = $stock->where($condition)->find();
        if ($result) {
            $this->assign('result', $result);
            $this->display("detailstock");
        } else {
            $this->error("错误的页面");
        }
		}
		else {
            $this->error("不知道你怎么进来的");
        }       
    } 
}