<?php
namespace Home\Controller;
use Think\Controller;

class CAController extends Controller {
    private $stockId;//当前交易股票的id
    private $finalPrice;//记录最终成交价
    private $buyList;//买委托列表，按价格倒序排序
    private $sellList;//卖委托列表，按价格顺序排序
    public function __construct($stock_id)
    {
        parent::__construct();
        $this->final_price = 0;
        $this->stockId = $stock_id;
    }
    public function buildBuyList()
    {
        $commission = D("Commission");
        //找出买方已提交（未成交）的委托，按价格和时间排序
        //TODO:委托时间应该限制在今天
        $condition['stockid'] = $this->stockId;
        $condition['direction'] = '0';
        $condition['state'] = '2';
        $condition['remain'] > 0;
        $this->buyList = $commission -> where($condition)
        ->order('commission_price DESC,commission_time')->select();
        //         $this->assign('data',$this->buylist);
        //         $this->display('Commission/index');//用视图index显示出查询结果
    }
    
    public function buildSellList(){
        $commission = D("Commission");
        //找出卖方已提交（未成交）的委托，按价格和时间排序
        $condition['stockid'] = $this->stockId;
        $condition['direction'] = '1';
        $condition['state'] = '2';
        $condition['remain'] > 0;
        $this->sellList = $commission -> where($condition)
        -> order('commission_price,commission_time') -> select();
        //         $this->assign('data',$this->selllist);
        //         $this->display('Commission/index');//用视图index显示出查询结果
    }
        
    //计算最终成交价
    public function calcOpeningPrice($minBuyPrice , $maxSellPrice)
    {
        //根据最大成交量，计算最后成交的匹配的平均价格，确定为总体集合竞价的成交价格
        $this->finalPrice = ($minBuyPrice + $maxSellPrice)/2;
    }
    
    public function callAuction()
    {
        $this->buildBuyList();
        $this->buildSellList();
        $sell = $this->sellList;
        $buy = $this->buyList;
        $minBuyPrice = 0;
        $maxSellPrice = 0;
        $finishFlag = false;
        $dealInfo = array();
        $dealNum = 0;
        $infoSync = new InfosyncController();
        
        foreach($buy as $buyKey => $buyCommission){
            if($finishFlag == true) break;
            
            foreach($sell as $sellKey => $sellCommission){
                if($buy[$buyKey]["remain"]==0){
                    break;
                }
                if($sell[$sellKey]["remain"]==0){
                    continue;
                }
                    
                if($buyCommission["commission_price"]>=$sellCommission["commission_price"]){
                    //在此情况下成交，比较谁的数量大
                    $minBuyPrice = $buyCommission["commission_price"];
                    $maxSellPrice = $sellCommission["commission_price"];
                    
                    $dealAmount = min($buy[$buyKey]["remain"],$sell[$sellKey]["remain"]);
                    echo $dealAmount."<br>";
                    
                    if($buy[$buyKey]["remain"]>$sell[$sellKey]["remain"]){
                        $buy[$buyKey]["remain"]=$buy[$buyKey]["remain"]-$sell[$sellKey]["remain"];
                        $sell[$sellKey]["remain"]=0;
                        $sell[$sellKey]["state"]=1;
                        //echo "sell光，buy剩下".$buy[$buyKey]["remain"]."<br>";
                    }else if($buy[$buyKey]["remain"]<$sell[$sellKey]["remain"]){
                        $sell[$sellKey]["remain"]=$sell[$sellKey]["remain"]-$buy[$buyKey]["remain"];
                        $buy[$buyKey]["remain"]=0;
                        $buy[$buyKey]["state"]=1;
                        //echo "buy光，sell剩下".$sell[$sellKey]["remain"]."<br>";
                    }
                    else{
                        $buy[$buyKey]["remain"]=0;
                        $buy[$buyKey]["state"]=1;
                        $sell[$sellKey]["remain"]=0;
                        $sell[$sellKey]["state"]=1;
                    }
                    
                    $dealInfo[$dealNum]["dealAmount"] = $dealAmount;
                    $dealInfo[$dealNum]["in_commission"] = $buy[$buyKey]["commissionid"];
                    $dealInfo[$dealNum]["out_commission"] = $sell[$sellKey]["commissionid"];
                    $dealInfo[$dealNum]["buyerStockHolderId"] = $buy[$buyKey]["stockholderid"];
                    $dealInfo[$dealNum]["sellerStockHolderId"] = $sell[$sellKey]["stockholderid"];
                    $dealNum++;
                }else{
                    $finishFlag = true;
                }
            }
        }
        
        $this->calcOpeningPrice($minBuyPrice, $maxSellPrice);
        
        //$infoSync->commissionUpdate($buy, $this->finalPrice);
        //$infoSync->commissionUpdate($sell, $this->finalPrice);
        //$infoSync->openingPriceUpdate($this->stockId, $this->finalPrice);
        //同步stock表的信息
        $infoSync->stockUpdate($this->stockId,$this->finalPrice);
        //同步deal表、stock_hold_info表、account表
        foreach($dealInfo as $oneDeal){
            $infoSync->commissionUpdate($oneDeal["in_commission"], $oneDeal["dealAmount"]);
            $infoSync->commissionUpdate($oneDeal["out_commission"], $oneDeal["dealAmount"]);
            
            $infoSync->dealInsert($this->stockId,$this->finalPrice,$oneDeal["dealAmount"], $oneDeal["in_commission"], $oneDeal["out_commission"]);
            
            $infoSync->stockHoldInfoUpdate($this->stockId, $oneDeal["buyerStockHolderId"], $oneDeal["dealAmount"], $this->finalPrice);
            $infoSync->stockHoldInfoUpdate($this->stockId, $oneDeal["sellerStockHolderId"], -1*$oneDeal["dealAmount"], $this->finalPrice);
            
            $infoSync->buyerAccountUpdate($oneDeal["buyerStockHolderId"], $oneDeal["dealAmount"]*$this->finalPrice);
            $infoSync->sellerAccountUpdate($oneDeal["sellerStockHolderId"], $oneDeal["dealAmount"]*$this->finalPrice);
        }
        
    }
}