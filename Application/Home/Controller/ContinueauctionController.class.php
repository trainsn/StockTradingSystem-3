<?php
namespace Home\Controller;
use Think\Controller;

class ContinueauctionController extends Controller {
    private $stockId;
    private $expectedPrice;
    private $commissionNum;
    private $state;
    private $direction;//记录连续竞价的方向
    private $commissionId;//记录竞价的对应委托id
    private $stockHolderId;
    private $list;//记录数据库中访问到的买或卖的委托列表

    public function __construct($data,$commissionid)
    {
        parent::__construct();
        $this->stockId = $data["stockid"];
        $this->direction = $data["direction"];
        $this->expectedPrice = $data["commission_price"];
        $this->commissionId = $commissionid;
        $this->state = $data["state"];
        $this->stockHolderId = $data["stockholderid"];
        $this->commissionNum = $data["commission_account"];
    }
    public function buildList()
    {
        $commission = M("commission");
        $condition["state"] = '2';
        $condition["remain"] > 0;
        //假如是买
        if($this->direction=='0')
        {
            //找出卖方已提交（未成交）的委托（价格低于买方期望价格），按价格和时间排序
            $condition["direction"] ='1';
            $condition["commission_price"] = array('elt',$this->expectedPrice);
            //$condition["commission_price"] <= $this->expectedPrice;
            $this->list = $commission -> where($condition)
            ->order("commission_price,commission_time")->select();
        }
        else
        {
            //找出买方已提交（未成交）的委托，按价格和时间排序
            $condition["direction"] ='0';
            $condition['commission_price'] = array('egt',$this->transaction_price);
            //$condition["commission_price"] >= $this->expectedPrice;
            $this->list = $commission -> where($condition)
            ->order("commission_price DESC,commission_time")->select();
        }
        
        //echo var_dump($this->list);
    }
    
    public function continueAuction()
    {
        $this->buildList();
        $dealInfo = array();
        $dealNum = 0;
        $infoSync = new InfosyncController();

        foreach ($this->list as $key => $oneCommission)
        {
            if($this->commissionNum == 0) break;
            
            
            $dealAmount = min($oneCommission["remain"],$this->commissionNum);
            
            if($oneCommission["remain"] < $this->commissionNum){
                $this->commissionNum -= $oneCommission["remain"];
                $this->list[$key]["remain"] = 0;
                $this->list[$key]["state"] = 1;
            }
            else{
                $this->list[$key]["remain"] -= $this->commissionNum;
                $this->commissionNum = 0;
                $this->state = 1;
            }
            
            $dealInfo[$dealNum]["dealAmount"] = $dealAmount;
            $dealInfo[$dealNum]["in_commission"] = $this->direction=='0'?$this->commissionId:$oneCommission["commissionid"];
            $dealInfo[$dealNum]["out_commission"] = $this->direction=='0'?$oneCommission["commissionid"]:$this->commissionId;
            $dealInfo[$dealNum]["buyerStockHolderId"] = $this->direction=='0'?$this->stockHolderId:$oneCommission["stockholderid"];
            $dealInfo[$dealNum]["sellerStockHolderId"] = $this->direction=='0'?$oneCommission["stockholderid"]:$this->stockHolderId;
            $dealInfo[$dealNum]["dealPrice"] = ($this->expectedPrice + $oneCommission["commission_price"])/2;
            $dealNum++;
            
        }
        
        foreach($dealInfo as $oneDeal){
            $infoSync->stockUpdate($this->stockId, $oneDeal["dealPrice"]);
    
            $infoSync->commissionUpdate($oneDeal["in_commission"], $oneDeal["dealAmount"]);
            $infoSync->commissionUpdate($oneDeal["out_commission"], $oneDeal["dealAmount"]);
            
            $infoSync->dealInsert($this->stockId,$oneDeal["dealPrice"],$oneDeal["dealAmount"], $oneDeal["in_commission"], $oneDeal["out_commission"]);
            
            $infoSync->stockHoldInfoUpdate($this->stockId, $oneDeal["buyerStockHolderId"], $oneDeal["dealAmount"], $oneDeal["dealPrice"]);
            $infoSync->stockHoldInfoUpdate($this->stockId, $oneDeal["sellerStockHolderId"], -1*$oneDeal["dealAmount"], $oneDeal["dealPrice"]);
            
            $infoSync->buyerAccountUpdate($oneDeal["buyerStockHolderId"], $oneDeal["dealAmount"]*$oneDeal["dealPrice"]);
            $infoSync->sellerAccountUpdate($oneDeal["sellerStockHolderId"], $oneDeal["dealAmount"]*$oneDeal["dealPrice"]);
        }
    }
}