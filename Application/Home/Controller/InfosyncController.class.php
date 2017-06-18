<?php
namespace Home\Controller;
use Think\Controller;

class InfosyncController extends Controller {
    private $time_state;//记录时间状态，0表示未开盘或已收盘，1/2/3表示集合竞价，4表示连续竞价
    public function __construct()
    {
        parent::__construct();

    }
    //集合竞价下的批量委托信息同步
//     public function commissionUpdate($commission_array,$highest_colume)
//     {
//         header("Content-Type:text/html; charset=utf-8");
//         $commission = M("Commission");
//         //记录委托匹配同步的股票数量
//         $stock_number = 0;
//         foreach ($commission_array as $commission_var)
//         {
//             $stock_number += (int)$commission_var['remain'];
//             $id = (int)$commission_var['id'];
//             //如果委托信息同步的量不大于成交量，则把委托的remain设为0，状态改为已成交
//             echo $stock_number."<br/>". $highest_colume."<br/>";
//             if($stock_number <= $highest_colume)
//             {
//                 $data['remain'] = 0;
//                 $data['state'] = '1';
//                 $commission ->where("commissionid = '$id'")-> save($data);
//             }
//             else//如果委托信息同步量超过成交量，则表示该委托只成交了一部分
//             {
//                 $transcation_amount =$stock_number - $highest_colume;
//                 $data['remain'] = $transcation_amount;
//                 $commission ->where("commissionid = '$id'")-> save($data);
//                 break;
//             }
//         }
//     }
    
    
//     public function commissionUpdate($array,$finalPrice){
//         header("Content-Type:text/html; charset=utf-8");
//         $sync = M("Commission");
//         foreach($array as $key => $commission){
//             if($commission["direction"]== "0"&&$commission["commission_price"]<$finalPrice) break;
//             if($commission["direction"]== "1"&&$commission["commission_price"]>$finalPrice) break;
            
//             $commissionId = (int)$commission["commissionid"];
//             $sync->where("commissionid = '$commissionId'")->save($commission);
//         }
//     }
    
    public function commissionUpdate($commissionId,$amount){
        header("Content-Type:text/html; charset=utf-8");
        $commission = M("Commission");
        $condition["commissionid"] = $commissionId;
        $prevInfo = $commission->where($condition)->find();
        $data["remain"] = $prevInfo["remain"] - $amount;
        $data["state"] = $amount==$prevInfo["remain"]?1:2;
        $commission->where($condition)->save($data);
    }
    
    public function openingPriceUpdate($stockId,$openingPrice){
        header("Content-Type:text/html; charset=utf-8");
        $history=M("history_info");
        $data["stockid"] = $stockId;
        $data["opening_price"]=$openingPrice;
        $data["history_date"]=date("Y-m-d");
        $history ->add($data);
    }
    
    public function closingPriceUpdate($stockId,$closingPrice){
        header("Content-Type:text/html; charset=utf-8");
        $history=M("history_info");
        $condition["stockid"] = $stockId;
        $data["closing_price"]=$closingPrice;
        $history ->where($condition)->save($data);
    }
    
    //成交后，在deal中插入成交信息
    public function dealInsert($stockId,$dealPrice,$dealAmount,$buyCommissionId,$sellCommissionId){
        header("Content-Type:text/html; charset=utf-8");
        $dealInfo["stockid"] = $stockId;
        $dealInfo["deal_price"] = $dealPrice;
        $dealInfo["dealed_amount"] = $dealAmount;
        $dealInfo["dealed_value"] = $dealPrice*$dealAmount;
        $dealInfo["deal_time"] = time();
        $dealInfo["in_commission"] = $buyCommissionId;
        $dealInfo["out_commission"] = $sellCommissionId;
        $deal = M("deal");
        $deal->add($dealInfo);
    }
    
    //修改stock表的股票当前价格，以及是否上涨
    public function stockUpdate($stockId,$currentPrice){
        header("Content-Type:text/html; charset=utf-8");
        $stock = M("stock");
        $condition["code"] = $stockId;
        $prevInfo = $stock->where($condition)->find();
        $data["trade"] = $currentPrice;
        //$data["isRaise"] = $currentPrice>$prevInfo["price"]?1:0;
        $stock->where($condition)->save($data);
    }
    
    public function stockHoldInfoUpdate($stockId,$stockHolderId,$changedNum,$price){
        header("Content-Type:text/html; charset=utf-8");
        $stockHold = M("hold_stock_info");
        $condition["stockid"] = $stockId;
        $condition["stockholderid"] = $stockHolderId;
        $prevInfo = $stockHold->where($condition)->find();
        $data["amount_total"] = (int)$prevInfo["amount_total"] + $changedNum;
        $data["amount_usable"] = (int)$prevInfo["amount_usable"] + $changedNum;
        $data["cost_price"] = $price;
        $stockHold->where($condition)->save($data);
    }
    
    public function stockHolderToUser($stockHolderId){
        $stockHolder = M("stockholder");
        $condition["stockholderid"] = $stockHolderId;
        $mapInfo = $stockHolder->where($condition)->find();
        return $mapInfo["userid"];
    }
    
    public function userToStockHolder($userId){
        $stockHolder = M("stockholder");
        $condition["userid"] = $userId;
        $mapInfo = $stockHolder->where($condition)->find();
        return $mapInfo["stockholderid"];
    }
    
    //对于买家，买成功，冻结资金与资金余额一起减少、股票资产增加、total不变
    public function buyerAccountUpdate($stockHolderId,$cost){
        header("Content-Type:text/html; charset=utf-8");
        $account = M("personal_stock_account");
        $userId = $this->stockHolderToUser($stockHolderId);
        $condition["userid"] = $userId;
        $prevInfo = $account->where($condition)->find();
        $data["bankroll_freezed"] = $prevInfo["bankroll_freezed"] - $cost;
        $data["bankroll"] = $prevInfo["bankroll"] - $cost;
        $data["total_stock"] = $prevInfo["total_stock"] + $cost;
        $account->where($condition)->save($data);
    }
    //对于卖家，卖成功，可取资金不变，可用资金与资金余额一起增加，股票资产减少，total不变
    public function sellerAccountUpdate($stockHolderId,$earn){
        header("Content-Type:text/html; charset=utf-8");
        $account = M("personal_stock_account");
        $userId = $this->stockHolderToUser($stockHolderId);
        $condition["userid"] = $userId;
        $prevInfo = $account->where($condition)->find();
        $data["bankroll_usable"] = $prevInfo["bankroll_usable"] + $earn;
        $data["bankroll"] = $prevInfo["bankroll"] + $earn;
        $data["total_stock"] = $prevInfo["total_stock"] - $earn;
        $account->where($condition)->save($data);
    }
    
    //对于买家，当成功提交买订单时，减少可用资金，增加冻结资金（资金余额不变）
    //假如可用资金>可取资金，则先扣除可用多余部分进行买，两者相等时再一起扣除
    public function buyerAccountUpdateOnBuy($stockHolderId,$cost){
        header("Content-Type:text/html; charset=utf-8");
        $account = M("personal_stock_account");
        $userId = $this->stockHolderToUser($stockHolderId);
        $condition["userid"] = $userId;
        $prevInfo = $account->where($condition)->find();
        $data["bankroll_freezed"] = $prevInfo["bankroll_freezed"] + $cost;
        $data["bankroll_usable"] = $prevInfo["bankroll_usable"] - $cost;
        $data["bankroll_in_cash"] = min($data["bankroll_usable"], $prevInfo["bankroll_in_cash"]);
        $account->where($condition)->save($data);
    }
    
    //当买家撤单时，解除冻结资金，但不可取，增加可用资金（资金余额不变）
    public function buyerAccountUpdateOnRevoke($stockHolderId,$cost){
        header("Content-Type:text/html; charset=utf-8");
        $account = M("personal_stock_account");
        $commission = M("commission");
        $userId = $this->stockHolderToUser($stockHolderId);
        $condition["userid"] = $userId;
        $prevInfo = $account->where($condition)->find();
        $data["bankroll_freezed"] = $prevInfo["bankroll_freezed"] - $cost;
        $data["bankroll_usable"] = $prevInfo["bankroll_usable"] + $cost;
        $account->where($condition)->save($data);
    }
    
}