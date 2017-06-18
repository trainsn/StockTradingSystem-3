<?php
namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller {
    private $time_state;//记录时间状态，0表示未开盘或已收盘，1/2/3表示集合竞价，4表示连续竞价
    public function __construct()
    {
        parent::__construct();
        $this->time_state = $this->timeJudge();
    }
    public function getTimeState()
    {
        return $this->time_state;
    }
    public function timeJudge()//判断时间状态
    {
        //$present_time = Date("H:i:s");
        //$present_time = strtotime("13:26:00");
    	//$present_time = strtotime("9:15:00");
    	//$present_time = strtotime("9:26:00");
    	//$present_time = strtotime("9:35:00");
    	$present_time = strtotime("10:30:00");
    	//$present_time = strtotime("11:30:00");
    	//$present_time = strtotime("13:00:00");
    	//$present_time = strtotime("15:00:00");
        //echo "lala".date("y-m-d H:i:s",$present_time).";<br/>";
        echo "当前时间为".date("y-m-d H:i:s").";<br/>";
        $time1 = strtotime("9:15:00");
        $time2 = strtotime("9:20:00");
        $time3 = strtotime("9:25:00");
        $time4 = strtotime("9:30:00");
        $time5 = strtotime("11:30:00");
        $time6 = strtotime("13:00:00");
        $time7 = strtotime("15:00:00");
        if($present_time >= $time1 and $present_time < $time2)
        {
            return 1;
            echo "处于集合竞价时间，"."您可以挂单，也可以撤单。";
        }
        else if($present_time >= $time2 and $present_time < $time3)
        {
            return 2;
            echo "处于集合竞价时间，"."您可以挂单，但不可以撤单。";
        }
        else if($present_time >= $time3 and $present_time < $time4)
        {
            return 3;
            
            echo "处于集合竞价时间，"."您不可以挂单，也不可以撤单。";
        } 
        else if(($present_time >= $time4 and $present_time < $time5) or
            ($present_time >= $time6 and $present_time < $time7))
        {
            echo "处于连续竞价时间。";
            return 4;
        }
        else 
        {
            return 0;
            echo "未开盘，请稍等。";
        }
    }
    
//    function startCallAuction(){
    	
 //      	$callAuction = new CAController('000856');
 //      	$callAuction->callAuction();
    	
//   }
    function startCallAuction(){
    	//对每一支股票调用一次集合竞价
    	$stock=M("stock");
    	$stockList=$stock->select();
    	//var_dump($stockList);
    	foreach($stockList as $stockInfo){
    		$callAuction = new CAController($stockInfo['code']);
    		$callAuction->callAuction();
    	}
    }
    

//     public function Auction()
//     {
//         $this->timeJudge();
//         if($this->time_state == 3)
//         {
//             $callauction = new CallauctionController();
//             $callauction->callAuction();
//             echo "调用集合竞价函数。";
//         }
//         else if($this->time_state == 4)
//         {
//             $this->continueAuction();
//             echo "调用连续竞价函数。";
//         }
//     }
    //     private $stockid;//记录股票id
    //     private $upperlimit;//记录涨跌幅限制的上限
    //     private $lowerlimit;//记录涨跌幅限制的下限
    //     private $openingprice;//记录开盘价
    //     private $closingprice;//记录收盘价
    //     private $currentprice;//记录当前价格
    
    //     public function getLowerLimit()
    //     {}
    //     public function getUpperLimit()
    //     {}
    //     public function getOpeningPrice()
    //     {}
    //     public function getClosingPrice()
    //     {}
    //     public function getCurrentPrice()
    //     {}
    //     public function setOpeningPrice()
    //     {}
    //     public function setClosingPrice()
    //     {}
    //     public function timeJudge()
    //     {}
    //     public function setPriceLimit()
    //     {}
}