<?php
namespace Home\Controller;
use Think\Controller;

class CommissionController extends Controller {
    private $commissionid;//记录
    private $stockid;//记录
    private $stockholderid;//记录
    private $time;//记录
    private $commission_price;//记录
    private $commission_amount;//记录
    private $direction;//记录
    private $state;//记录
    public  $remain;//记录
    
    /* public function Commission($commission)
    {
        $this->commissionid = $commission->getCommissionid();
        $this->stockid = $commission->getStockid();
        $this->stockholderid = $commission->getStockholderid();
        $this->time = $commission->getTime();
        $this->commission_price = $commission->getCommission_price();
        $this->commission_amount = $commission->getCommission_amount();
        $this->direction = $commission->getDirection();
        $this->state = $commission->getState();
        $this->remain = $commission->getRemain();
    } */
    public function __construct(&$array)
    {
        parent::__construct();
        $this->commissionid = $array['commissionid'];
        $this->stockid = $array['stockid'];
        $this->stockholderid = $array['stockholderid'];
        $this->time = $array['time'];
        $this->commission_price = $array['commission_price'];
        $this->commission_amount = $array['commission_amount'];
        $this->direction = $array['direction'];
        $this->state = $array['state'];
        $this->remain = $array['remain'];
    }
    public function getCommissionid()
    {
        return $this->commossionid;
    }
    public function getStockid()
    {
        return $this->stockid;
    }
    public function getStockholderid()
    {
        return $this->stockholderid;
    }
    public function getTime()
    {
        return $this->time;
    }
    public function getCommission_price()
    {
        return $this->commission_price;
    }
    public function getCommission_amount()
    {
        return $this->commission_amount;
    }
    public function getDirection()
    {
        return $this->direction;
    }
    public function getState()
    {
        return $this->state;
    }
    public function getRemain()
    {
        return $this->remain;
    }
    public function setRemain($remain)
    {
        $this->remain = $remain;
    }
    public function setState($state)
    {
        $this->state = $state;
    }

}